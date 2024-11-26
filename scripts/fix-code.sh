#!/bin/bash

source functions.sh

SCRIPT_LABEL="fix-code.sh"

echo "$SCRIPT_LABEL: Starting fixing code..."
execute_command "$SCRIPT_LABEL" "Fixing code style with PHP-CS-Fixer" 0 "/var/www" composer run-script cs-fix
execute_command "$SCRIPT_LABEL" "Applying code refactorings with PHPCBF" 0 "/var/www" composer run-script phpcbf
execute_command "$SCRIPT_LABEL" "Applying code refactorings with Rector" 0 "/var/www" composer run-script rector
echo "$SCRIPT_LABEL: Fixing code completed"
