#!/bin/bash

cd /var/www

echo "Starting building app in PROD environment..."

if [ ! -f .env.local ]; then
  echo "Creating .env.local from .env..."
  cp .env .env.local
fi

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction || exit 1

echo "Optimizing environment variables..."
composer dump-env prod || exit 1

#echo "Setting up database..."
#php bin/console doctrine:database:create --if-not-exists --env=prod --no-interaction || exit 1
#php bin/console doctrine:migrations:migrate --env=prod --no-interaction || exit 1

echo "Clearing cache..."
php bin/console cache:clear --env=prod --no-interaction || exit 1

echo "Building assets..."
php bin/console importmap:install --no-interaction || exit 1
php bin/console asset-map:compile --env=prod || exit 1

echo "Warming up cache..."
php bin/console cache:warmup --env=prod --no-interaction || exit 1

echo "Generating sitemaps..."
php bin/console presta:sitemaps:dump public --env=prod --no-interaction || exit 1

echo "Building Sass..."
php bin/console sass:build -v || exit 1

echo "Building app completed successfully!"

exec "$@"