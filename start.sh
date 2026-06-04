#!/bin/bash
set -e

echo "=== Starting NaruBranch Application ==="

echo "=== Checking DB connection ==="
php artisan db:show --no-ansi || echo "WARNING: Could not get DB info, continuing anyway..."

echo "=== Running migrations ==="
php artisan migrate --force --no-interaction

echo "=== Running seeders ==="
php artisan db:seed --force --no-interaction

echo "=== Clearing caches ==="
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "=== Starting Laravel server ==="
php artisan serve --host=0.0.0.0 --port=10000
