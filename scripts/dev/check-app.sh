#!/bin/bash

source functions.sh

SCRIPT_LABEL="check-app.sh"

echo "$SCRIPT_LABEL: Starting checking App..."
execute_command "$SCRIPT_LABEL" "Checking system requirements" 0 "/var/www" symfony check:requirements
execute_command "$SCRIPT_LABEL" "Checking outdated composer packages" 0 "/var/www" composer outdated
execute_command "$SCRIPT_LABEL" "Checking security vulnerabilities" 0 "/var/www" symfony check:security
execute_command "$SCRIPT_LABEL" "Checking routes" 0 "/var/www" symfony console debug:router
#execute_command "$SCRIPT_LABEL" "Checking doctrine mappings" 0 "/var/www" symfony console doctrine:schema:validate
echo "$SCRIPT_LABEL: Checking App completed"
