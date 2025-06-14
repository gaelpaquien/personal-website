#!/bin/bash

cd /var/www

echo "Starting building app in DEV environment..."

echo "Installing dependencies..."
composer install || exit 1

echo "Setting up database..."
php bin/console doctrine:database:create --if-not-exists --env=dev --no-interaction || exit 1
php bin/console doctrine:migrations:migrate --env=dev --no-interaction || exit 1

echo "Clearing cache..."
symfony console cache:clear --env=dev || exit 1

echo "Building app completed successfully!"

exec "$@"