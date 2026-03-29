# Campus Ledger

A small Laravel app for managing students, programs, and courses.

## What it does

- Admin dashboard at `/`
- Student roster with search and filters
- Create, edit, and view student records
- Manage programs and courses

## Stack

- Laravel
- Blade templates
- Tailwind CSS
- PostgreSQL

## Local setup

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Update `.env` with your database settings, then run:

```bash
php artisan migrate
npm run dev
php artisan serve
```

The lookup data, starter programs, and starter courses are inserted during migration.

## Useful commands

```bash
php artisan test
npm run build
```
