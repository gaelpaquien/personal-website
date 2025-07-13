#!/bin/bash
set -e

log() {
    echo "[$(date '+%H:%M:%S')] $1"
}

log "START: Maintenance gaelpaquien.com"

log "Installing dependencies"
composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

log "Optimizing environment variables"
composer dump-env prod

log "Running migrations"
php bin/console doctrine:migrations:migrate --env=prod --no-interaction

log "Clearing cache"
php bin/console cache:clear --env=prod --no-interaction

log "Building assets"
php bin/console importmap:install --no-interaction
php bin/console sass:build -v
php bin/console asset-map:compile --env=prod

log "Warming up cache"
php bin/console cache:warmup --env=prod --no-interaction

log "Generating sitemaps"
php bin/console presta:sitemaps:dump public --env=prod --no-interaction

log "Cleaning temporary files"
rm -rf var/log/* var/cache/*

log "END: Maintenance gaelpaquien.com completed"