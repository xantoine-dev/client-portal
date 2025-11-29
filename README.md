# Client Portal & Time-Logging App (Laravel 10)

Companion portal for external clients to log time, submit change requests, and track project progress. Staff/Admin users can review and approve submissions, manage statuses, and export reports (CSV/PDF).

## Stack & Features
- Laravel 10, PHP 8.1+ (Breeze Blade + Bootstrap auth scaffolding)
- MySQL/MariaDB, Eloquent ORM, PSR-4 autoloading
- Roles: `admin`, `staff`, `client` (role middleware + policies)
- Entities: Clients, Projects, Time Logs, Change Requests (with approvals/status)
- Reporting: CSV via `league/csv`, PDF via `dompdf/dompdf`
- Seed data: admin/staff/client users, client/project, sample logs & change requests

## macOS Setup (MacBook Pro 2017)
> Commands assume `zsh` + Homebrew. macOS filesystems are usually case-insensitive—match paths exactly.

1) Install prerequisites
```bash
brew install php@8.2
brew link php@8.2 --force --overwrite   # if multiple PHP versions
brew install composer
brew install mysql    # or: brew install mariadb
brew install node
```
2) Start DB service
```bash
brew services start mysql   # or mariadb
mysql -u root -p -e "CREATE DATABASE client_portal;"
```
3) Project install
```bash
git clone <repo> ClientPortal
cd ClientPortal
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install
npm run build   # or: npm run dev -- --watch
```
4) Serve locally
- Quick: `php artisan serve` (http://127.0.0.1:8000)
- Optional: `laravel/valet` if you prefer Valet (`brew install nginx dnsmasq` handled by Valet).

Node.js note (fallback): if Homebrew Node fails on macOS 13, use the official tarball:
```bash
mkdir -p ~/local/nodejs
cd ~/local/nodejs
curl -LO https://nodejs.org/dist/v18.20.4/node-v18.20.4-darwin-x64.tar.gz
tar -xzf node-v18.20.4-darwin-x64.tar.gz
echo 'export PATH="$HOME/local/nodejs/node-v18.20.4-darwin-x64/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

## Environment (.env)
Key settings to update:
```
APP_NAME="Client Portal"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=client_portal
DB_USERNAME=root
DB_PASSWORD=your_password
```

## Database Schema (new tables)
- `users`: adds `role` enum (`admin|staff|client`)
- `clients`, `projects`
- Pivot `client_user`
- `time_logs`: `project_id`, `user_id`, `date`, `hours`, `description`, `approved`, `approved_by`
- `change_requests`: `project_id`, `requested_by`, `description`, `status`

## Running
- Dev server: `php artisan serve`
- Assets: `npm run dev` (watch) or `npm run build`
- Migrations/seeders: `php artisan migrate --seed`
- Tests (PHPUnit): `php artisan test`
- Fast sqlite test run (no MySQL needed): `DB_CONNECTION=sqlite DB_DATABASE=":memory:" php artisan test`
- Note: On PHP 8.5 you may see a deprecation notice from `nunomaduro/collision` (reflection `setAccessible`); it is benign and does not fail tests.

## Auth & Roles
- Breeze-style auth (Blade + Bootstrap), email verification enabled.
- Middleware: `auth`, `verified`, `role:client` for portal; `role:admin,staff` for back office.
- Policies: `TimeLogPolicy`, `ChangeRequestPolicy` enforce ownership and approvals.

Seeded logins:
- Admin: `admin@example.com` / `password`
- Staff: `staff@example.com` / `password`
- Client: `client@example.com` / `password`

## Key Commands (artisan)
```bash
php artisan migrate
php artisan db:seed
php artisan serve
php artisan test
php artisan queue:work   # if you add async notifications
```

## Frontend
- Bootstrap 5 via Vite (`resources/sass/app.scss`, `resources/js/app.js`)
- Layouts: `layouts/app.blade.php` (auth), `layouts/guest.blade.php` (public)

## Notes
- Reports: `/admin/reports` (CSV/PDF exports for time logs, filter by client/project/status)
- Portal: `/portal/dashboard`, `/portal/time-logs`, `/portal/change-requests`
- Admin/Staff: `/admin/time-logs`, `/admin/change-requests`, `/admin/reports` (also available under `/staff/*`)
- CSRF protection is on by default; validation via FormRequests; policies enforced on controllers.
