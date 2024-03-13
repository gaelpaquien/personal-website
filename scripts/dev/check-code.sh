#!/bin/bash

source functions.sh

SCRIPT_LABEL="check-code.sh"

echo "$SCRIPT_LABEL: Starting checking code..."
execute_command "$SCRIPT_LABEL" "Running PHP CS Fixer" 8 "/var/www" composer run-script cs-check
execute_command "$SCRIPT_LABEL" "Running PHP Code Sniffer" 0 "/var/www" composer run-script phpcs
execute_command "$SCRIPT_LABEL" "Running PHPStan" 0 "/var/www" composer run-script phpstan
execute_command "$SCRIPT_LABEL" "Running Rector" 0 "/var/www" composer run-script rector-dry
execute_command "$SCRIPT_LABEL" "Linting Twig files" 0 "/var/www" symfony console lint:twig templates
execute_command "$SCRIPT_LABEL" "Linting YAML files" 0 "/var/www" symfony console lint:yaml config translations
echo "$SCRIPT_LABEL: Checking code completed"
