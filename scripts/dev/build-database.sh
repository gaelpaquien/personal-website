#!/bin/bash

source functions.sh

SCRIPT_LABEL="build-database.sh"

echo "$SCRIPT_LABEL: Starting building database..."
execute_command "$SCRIPT_LABEL" "Creating database if not exists" 0 "/var/www" symfony console doctrine:database:create --if-not-exists --env=dev
execute_command "$SCRIPT_LABEL" "Applying migrations" 0 "/var/www" symfony console doctrine:migrations:migrate --no-interaction --env=dev
execute_command "$SCRIPT_LABEL" "Loading fixtures" 0 "/var/www" symfony console doctrine:fixtures:load --no-interaction --env=dev
echo "$SCRIPT_LABEL: Building database completed"
