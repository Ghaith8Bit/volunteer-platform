# Volunteer Platform

This repository contains the source code for a simple volunteer management API built with [Laravel](https://laravel.com/).

## Getting Started

```bash
# Install PHP dependencies
composer install

# Copy the example environment and generate an app key
cp .env.example .env
php artisan key:generate
```

Configure the database credentials and any other options in your `.env` file before continuing.

### Environment Variables

The `.env.example` file contains all of the environment variables used by the application. Common settings include:

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=               # generated via `php artisan key:generate`
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Database Migrations & Seeding

Run the migrations and seeders to create example users and opportunities:

```bash
php artisan migrate --seed
```

The seeders defined in `database/seeders` will create an administrator, organiser and volunteer account along with some sample opportunities.

## Running Tests

Execute the full test suite with:

```bash
php artisan test
```

## API Usage

See [`Volunteer_Platform_API_Documentation.md`](Volunteer_Platform_API_Documentation.md) for a list of endpoints and examples. A Postman collection is provided in `Full Volunteer Platform Collection.postman_collection.json` which can be imported for quick testing.

