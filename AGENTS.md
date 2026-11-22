# OpenCode Agents - Quick Reference

## Project Root
`C:\localhost\businesslicense`

## Useful Artisan Commands
- `php artisan list` - list all commands
- `php artisan test --filter=TestName` - run specific test
- `php artisan route:list` - list registered routes
- `php artisan route:clear` - clear route cache
- `php artisan view:clear` - clear view cache
- `php artisan cache:clear` - clear application cache
- `php artisan config:clear` - clear configuration cache
- `vendor/bin/pint --format agent` - format PHP code

## Key Directories
- `app/` - Application code (controllers, models, middleware, etc.)
- `routes/` - Route definitions (`web.php`, `api.php`, etc.)
- `resources/views/` - Blade templates
- `resources/css/` - CSS source files
- `public/assets/` - Deployed assets (CSS, JS, icons)
- `database/` - Migrations, seeders, factories
- `tests/` - PHPUnit feature and unit tests

## CSS Workflow
- Edit `resources/css/app.css` 
- Copy file: `copy resources/css/app.css public/assets/css/app.css`
- `public/assets/css/app.css` must stay byte-identical to `resources/css/app.css`

## Icon System
- 50+ lucide SVGs in `public/assets/icons/`
- Served via `<x-icon name="..." />` Blade component
- Icons are plain SVG files, no npm/Vite needed

## Admin Access
- Users with `is_admin` boolean flag on their `users` table
- Protected by `admin` middleware (`EnsureUserIsAdmin`)
- Login uses manual Laravel auth (no packages)
- RateLimiter: 5-attempt RateLimiter on LoginRequest
- Session regeneration after login
- `redirect()->intended(...)` pattern

## Visual Identity
- Navy: `#102A43`, `#0B1F33`, `#174A78`
- Gold accent: `#C8A45D` (sparingly)
- Gold text contrast: `--c-gold-text: #7D5C1D`
- Fonts: Manrope (headings) + Inter (body), self-hosted
- WCAG 2.2 AA compliant
- Responsive: 360–1440px
- `prefers-reduced-motion` support
- Unique SEO title/description per page

## Legal
- Footer disclaimer: never claim government authority
- No invented officials/figures/contacts
- Private agency platform only

## WCAG & Accessibility
- WCAG 2.2 AA target
- `prefers-reduced-motion` respect
- Console error monitoring
- Lighthouse audits: accessibility, best practices, SEO

## Design Principles
- Editorial, anti-"AI-slop" design
- No fake stats or invented data
- Authentic, verifiable content only
- Permits and pricing managed from admin CRUD
- Sectors/Opportunities/News: full admin CRUD
- Admin profile: edit name, phone, country, company

## Test Strategy
- 42 PHPUnit tests, 220 assertions
- Test both guest restrictions and admin functionality
- Use `RefreshDatabase` trait for database isolation
- Factories for test data setup
- Test public-facing pages as well as admin routes

## Last Verified
- All 42 tests pass
- Lighthouse: 100 accessibility, 100 best practices, 100 SEO on /admin, /admin/enquiries, /admin/enquiries/{id}
- CSS in sync
- Pint formatted
- MySQL 9.1, DB `businesslicense`
- Admin profile edit: name, phone, country, company
- Admin nav: Dashboard, Enquiries, Permits, Sectors/Opportunities/News, Profile