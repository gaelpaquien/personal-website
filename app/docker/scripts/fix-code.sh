#!/bin/bash

echo "Starting fixing code..."
cd /var/www && composer run-script cs-fix || exit 1
cd /var/www && composer run-script phpcbf || exit 1
cd /var/www && composer run-script rector || exit 1
echo "Fixing code completed"