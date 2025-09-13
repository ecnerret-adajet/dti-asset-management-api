# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Backend (Laravel)
- **Start development server**: `php artisan serve --port 8781`
- **Run database migrations**: `php artisan migrate`
- **Seed database**: `php artisan db:seed`
- **Refresh database**: `php artisan migrate:fresh --seed`
- **Run all tests**: `vendor/bin/phpunit` or `php artisan test`
- **Run specific test**: `php artisan test --filter=TestName`
- **Run feature tests only**: `vendor/bin/phpunit tests/Feature`
- **Run unit tests only**: `vendor/bin/phpunit tests/Unit`
- **Clear caches**: `php artisan cache:clear` and `php artisan config:clear`
- **Generate application key**: `php artisan key:generate`

### Frontend (Laravel Mix + Vue.js)
- **Install dependencies**: `npm install`
- **Development build**: `npm run dev`
- **Watch for changes**: `npm run watch`
- **Hot reload with BrowserSync**: `npm run hot` (proxies to localhost:8000)
- **Production build**: `npm run prod`

## Architecture Overview

This is a **Laravel 8 + Vue.js 3 + Inertia.js** application for asset/inventory management.

### Backend Stack
- **Framework**: Laravel 8 (PHP 7.3|8.0|8.2 for production)
- **Authentication**: Laravel Sanctum for API tokens
- **Database**: MySQL/PostgreSQL (standard Laravel setup)
- **Auditing**: owen-it/laravel-auditing for tracking data changes
- **Deployment**: Laravel Vapor (serverless on AWS, PHP 8.2 runtime)
- **API**: RESTful structure following Laravel conventions
- **Routing**: Ziggy for sharing Laravel routes with Vue.js frontend

### Frontend Stack
- **Framework**: Vue.js 3
- **State Management**: Pinia
- **Routing**: Vue Router + Inertia.js (SPA without API)
- **Build Tool**: Laravel Mix v6 (webpack wrapper)
- **Dev Server**: BrowserSync (proxies to http://127.0.0.1:8000)
- **UI Libraries**: 
  - vue-multiselect
  - vue3-select2-component  
  - vue-sweetalert2 (alerts/modals)
  - vue3-toastify (notifications)
- **HTTP Client**: Axios
- **Admin Theme**: Metronic (located in resources/metronic/)

### Key Application Areas
Based on controllers and models, this appears to be an **asset management system** with:

- **Asset Management**: Assets, AssetTypes, Locations, Statuses
- **Inventory Operations**: Orders, Receivings, Suppliers, Customers
- **User Management**: Users, Roles, Permissions (RBAC)
- **Auditing**: Transaction tracking and stock cards

### File Structure
- **Backend**: Standard Laravel structure (app/, routes/, database/, etc.)
- **Frontend**: Vue components in `resources/js/Pages/`
- **API Routes**: `routes/api.php`
- **Web Routes**: `routes/web.php` (Inertia routes)
- **Models**: `app/Models/` (Asset, User, Order, etc.)
- **Controllers**: `app/Http/Controllers/` (AssetsController, UsersController, etc.)

### Testing
- **Framework**: PHPUnit
- **Configuration**: `phpunit.xml`
- **Test Directories**: `tests/Unit/` and `tests/Feature/`

## Important Notes

### Critical Issues
- **DUPLICATE SETUP BLOCKS**: `resources/js/app.js:16-30` has duplicate `setup` functions that will cause initialization problems
- **Frontend assets disabled in production**: Vapor build config has npm build commented out (`vapor.yml:11`)

### Development Notes
- Uses **Inertia.js** pattern - backend renders Vue components instead of traditional API
- BrowserSync proxies to port 8000, ensure Laravel dev server matches
- Admin UI uses **Metronic theme** for styling consistency
- Deployment configured for **Laravel Vapor** (check `vapor.yml`)

### Build Configuration
- **Laravel Mix**: Handles Vue.js compilation, PostCSS processing, and Metronic theme assets
- **Chunk naming**: Uses `[name].js?id=[chunkhash]` pattern for cache busting
- **Production**: Automatically enables versioning via `mix.version()`