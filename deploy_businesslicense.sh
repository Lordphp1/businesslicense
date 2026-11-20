#!/bin/bash
# Deploy script for Business License project
# Runs on the VPS at /var/www/html/businesslicense/deploy_businesslicense.sh

set -e

REPO="https://github.com/Lordphp1/businesslicense.git"
DIR="/var/www/html/businesslicense"

echo "=== Business License Deployment Started ==="

# First run: clone the repo
if [ ! -d "$DIR/.git" ]; then
    echo "First deployment — cloning repository..."
    git clone "$REPO" "$DIR"
    cd "$DIR"
else
    echo "Pulling latest changes..."
    cd "$DIR"
    git pull origin main
fi

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Setting up environment..."
if [ ! -f "$DIR/.env" ]; then
    cp "$DIR/.env.production" "$DIR/.env" 2>/dev/null || cp "$DIR/.env.example" "$DIR/.env"
fi

echo "Generating application key (if needed)..."
php artisan key:generate --force 2>/dev/null || true

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders (permits)..."
php artisan db:seed --force

echo "Clearing and caching config..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Setting permissions..."
chown -R www-data:www-data "$DIR/storage" "$DIR/bootstrap/cache" 2>/dev/null || true
chmod -R 775 "$DIR/storage" "$DIR/bootstrap/cache" 2>/dev/null || true

echo "=== Business License Deployment Complete ==="
