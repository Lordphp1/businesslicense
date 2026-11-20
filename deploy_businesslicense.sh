#!/bin/bash
set -e

DIR="/var/www/html/businesslicense"
DOMAIN="economicdevelopmentagencyuae.com"

echo "=== Business License Deployment Started ==="

cd "$DIR"

# Pull latest code
git pull origin main

# Composer dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer install --no-dev --optimize-autoloader --no-interaction

# Production .env configuration
if [ ! -f "$DIR/.env" ]; then
    cp "$DIR/.env.example" "$DIR/.env"
    php artisan key:generate --force
fi
sed -i 's|^APP_NAME=.*|APP_NAME="Economic Development Agency UAE"|' "$DIR/.env"
sed -i 's|^APP_ENV=.*|APP_ENV=production|' "$DIR/.env"
sed -i 's|^APP_DEBUG=.*|APP_DEBUG=false|' "$DIR/.env"
sed -i 's|^APP_URL=.*|APP_URL=https://economicdevelopmentagencyuae.com|' "$DIR/.env"

# Ensure SQLite file exists
touch "$DIR/database/database.sqlite" 2>/dev/null || true

# Run database migrations and seed initial data
php artisan migrate --force
php artisan db:seed --force

# Create default administrator if not present
php artisan app:create-admin-user admin@economicdevelopmentagencyuae.com --name="Administrator" --password="AdminPassword2026!" 2>/dev/null || true

# Cache framework structures
php artisan config:cache
php artisan route:cache
php artisan view:cache

# File ownership and permissions (AlmaLinux uses apache or nginx)
WEB_USER=apache
id -u apache >/dev/null 2>&1 || WEB_USER=nginx
id -u www-data >/dev/null 2>&1 && WEB_USER=www-data
chown -R $WEB_USER:$WEB_USER "$DIR/storage" "$DIR/bootstrap/cache" "$DIR/database" 2>/dev/null || true
chmod -R 775 "$DIR/storage" "$DIR/bootstrap/cache" "$DIR/database" 2>/dev/null || true

# SELinux context for AlmaLinux
if command -v chcon >/dev/null 2>&1; then
    chcon -R -t httpd_sys_rw_content_t "$DIR/storage" "$DIR/bootstrap/cache" "$DIR/database" 2>/dev/null || true
    setsebool -P httpd_can_network_connect 1 2>/dev/null || true
    setsebool -P httpd_unified 1 2>/dev/null || true
fi

# Configure Apache (httpd) VirtualHost
if [ -d "/etc/httpd/conf.d" ]; then
    echo "Writing Apache configuration..."
    cat > /etc/httpd/conf.d/economicdevelopmentagencyuae.conf << 'APACHECONF'
<VirtualHost *:80>
    ServerName economicdevelopmentagencyuae.com
    ServerAlias www.economicdevelopmentagencyuae.com
    DocumentRoot /var/www/html/businesslicense/public

    <Directory /var/www/html/businesslicense/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/businesslicense_error.log
    CustomLog /var/log/httpd/businesslicense_access.log combined
</VirtualHost>
APACHECONF
    apachectl configtest 2>/dev/null || httpd -t 2>/dev/null || true
    systemctl reload httpd 2>/dev/null || systemctl restart httpd 2>/dev/null || true
fi

# Configure Nginx VirtualHost (if nginx is active)
if [ -d "/etc/nginx/conf.d" ] && systemctl is-active --quiet nginx 2>/dev/null; then
    echo "Writing Nginx configuration..."
    cat > /etc/nginx/conf.d/economicdevelopmentagencyuae.conf << 'NGINXCONF'
server {
    listen 80;
    server_name economicdevelopmentagencyuae.com www.economicdevelopmentagencyuae.com;
    root /var/www/html/businesslicense/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php-fpm/www.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINXCONF
    nginx -t 2>/dev/null && systemctl reload nginx 2>/dev/null || true
fi

# Request/Renew SSL certificate via Certbot
echo "Checking SSL with Certbot..."
if ! command -v certbot >/dev/null 2>&1; then
    dnf install -y epel-release 2>/dev/null || true
    dnf install -y certbot python3-certbot-apache python3-certbot-nginx 2>/dev/null || true
fi

if command -v certbot >/dev/null 2>&1; then
    certbot --apache -d "$DOMAIN" -d "www.$DOMAIN" --non-interactive --agree-tos -m lordphp319@gmail.com --redirect 2>/dev/null || \
    certbot --nginx -d "$DOMAIN" -d "www.$DOMAIN" --non-interactive --agree-tos -m lordphp319@gmail.com --redirect 2>/dev/null || true
fi

echo "=== Business License Deployment Complete ==="
