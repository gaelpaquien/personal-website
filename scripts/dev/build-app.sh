#!/bin/bash

source functions.sh

SCRIPT_LABEL="build-app.sh"

echo "$SCRIPT_LABEL: Starting building app..."
execute_command "$SCRIPT_LABEL" "Installing composer dependencies" 0 "/var/www" composer install
execute_command "$SCRIPT_LABEL" "Optimizing composer autoloader" 0 "/var/www" composer dump-autoload --optimize
execute_command "$SCRIPT_LABEL" "Building assets" 0 "/var/www" symfony console asset-map:compile
execute_command "$SCRIPT_LABEL" "Warmup cache" 0 "/var/www" symfony console cache:warmup --env=dev
execute_command "$SCRIPT_LABEL" "Building sitemaps" 0 "/var/www" symfony console presta:sitemaps:dump public --env=dev
echo "$SCRIPT_LABEL: Building app completed"
