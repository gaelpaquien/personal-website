#!/bin/bash

source functions.sh

SCRIPT_LABEL="start.sh"

echo "$SCRIPT_LABEL: Starting building app..."
execute_command "$SCRIPT_LABEL" "tmp..." 0 "/var/www" composer require symfony/runtime
execute_command "$SCRIPT_LABEL" "Clearing cache" 0 "/var/www" symfony console cache:clear --env=dev
execute_command "$SCRIPT_LABEL" "Installing composer dependencies" 0 "/var/www" composer install
execute_command "$SCRIPT_LABEL" "Optimizing composer autoloader" 0 "/var/www/" composer dump-autoload --optimize
execute_command "$SCRIPT_LABEL" "Installing importmap" 0 "/var/www/" symfony console importmap:install
execute_command "$SCRIPT_LABEL" "Building assets" 0 "/var/www/" symfony console asset-map:compile
execute_command "$SCRIPT_LABEL" "Warmup cache" 0 "/var/www/" symfony console cache:warmup --env=dev
execute_command "$SCRIPT_LABEL" "Building sitemaps" 0 "/var/www/" symfony console presta:sitemaps:dump public --env=dev
echo "$SCRIPT_LABEL: Building app completed"

#echo "$SCRIPT_LABEL: Starting building database..."
#execute_command "$SCRIPT_LABEL" "Creating database if not exists" 0 "/var/www" symfony console doctrine:database:create --if-not-exists --env=dev
#execute_command "$SCRIPT_LABEL" "Applying migrations" 0 "/var/www" symfony console doctrine:migrations:migrate --no-interaction --env=dev
#execute_command "$SCRIPT_LABEL" "Loading fixtures" 0 "/var/www" symfony console doctrine:fixtures:load --no-interaction --env=dev
#echo "$SCRIPT_LABEL: Building database completed"

echo "$SCRIPT_LABEL: Starting checking app..."
execute_command "$SCRIPT_LABEL" "Checking system requirements" 0 "/var/www" symfony check:requirements
execute_command "$SCRIPT_LABEL" "Checking outdated composer packages" 0 "/var/www" composer outdated
execute_command "$SCRIPT_LABEL" "Checking security vulnerabilities" 0 "/var/www" symfony check:security
execute_command "$SCRIPT_LABEL" "Checking routes" 0 "/var/www" symfony console debug:router
#execute_command "$SCRIPT_LABEL" "Checking doctrine mappings" 0 "/var/www" symfony console doctrine:schema:validate
echo "$SCRIPT_LABEL: Checking app completed"

echo "$SCRIPT_LABEL: Starting checking code..."
execute_command "$SCRIPT_LABEL" "Running PHP CS Fixer" 8 "/var/www" composer run-script cs-check
execute_command "$SCRIPT_LABEL" "Running PHP Code Sniffer" 0 "/var/www" composer run-script phpcs
execute_command "$SCRIPT_LABEL" "Running PHPStan" 0 "/var/www" composer run-script phpstan
execute_command "$SCRIPT_LABEL" "Running Rector" 0 "/var/www" composer run-script rector-dry
execute_command "$SCRIPT_LABEL" "Linting Twig files" 0 "/var/www" symfony console lint:twig templates
execute_command "$SCRIPT_LABEL" "Linting YAML files" 0 "/var/www" symfony console lint:yaml config translations
echo "$SCRIPT_LABEL: Checking code completed"

execute_command "$SCRIPT_LABEL" "Starting Sass in the foreground" 0 "/var/www" sass --watch assets/styles/scss:assets/styles/css --style=compressed
execute_command "$SCRIPT_LABEL" "Starting PHP-FPM" 0 "/var/www" php-fpm &
execute_command "$SCRIPT_LABEL" "Starting Nginx" 0 "/var/www" nginx -g "daemon off;"
