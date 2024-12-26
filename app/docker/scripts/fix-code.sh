#!/bin/bash

SCRIPT_LABEL="fix-code.sh"

echo "$SCRIPT_LABEL: Starting fixing code..."
cd /var/www && composer run-script cs-fix || exit 1
cd /var/www && composer run-script phpcbf || exit 1
cd /var/www && composer run-script rector || exit 1
echo "$SCRIPT_LABEL: Fixing code completed"