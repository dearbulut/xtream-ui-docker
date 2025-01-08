#!/bin/bash

# Copy .env file if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Wait for MySQL to be ready
until nc -z -v -w30 mysql 3306
do
  echo "Waiting for MySQL to be ready..."
  sleep 5
done

# Wait for Redis to be ready
until nc -z -v -w30 redis 6379
do
  echo "Waiting for Redis to be ready..."
  sleep 5
done

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link

# Run database migrations
php artisan migrate --force

# Run composer scripts now that database is ready
composer dump-autoload
php artisan package:discover

# Create admin user if not exists
php artisan tinker --execute="
if (!\App\Models\User::where('email', 'admin@example.com')->exists()) {
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password')
    ]);
}
"

# Cache configuration and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the application
php artisan serve --host=0.0.0.0 --port=8000