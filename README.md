# lvdev

> Laravel & Vue.js SPA

## Getting started

### Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/7.x/installation#installation)

Setup Config. Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

Install dependencies

```bash
# Install composer dependencies
composer install

# Install npm dependencies
npm install
```

Generate a new application key

```bash
php artisan key:generate
```

Run the database migrations (Set the database connection in .env before migrating)

```bash
php artisan migrate

# Migrate with seed
php artisan migrate --seed

# Migrate fresh with seed
php artisan migrate:fresh --seed
```

Compile the frontend vue app

```bash
# Production build
npm run prod
npm run prod-sass

# Dev build
npm run dev
npm run dev-sass

# Run both command (This won't work on watch)
npm run dev && npm run dev-sass

# Watch for changes
npm run watch
npm run watch-sass
```

Start laravel development server

```bash
php artisan serve

# Start server in specific port
php artisan serve --port=8000
```

## Demo

The app is live at [lvdev.herokuapp.com](https://lvdev.herokuapp.com)
