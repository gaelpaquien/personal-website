#!/bin/bash

echo "check-code.sh: Running PHP CS Fixer..."
(cd /var/www && composer run-script cs-check) || {
    EXIT_CODE=$?
    if [ $EXIT_CODE -ne 8 ]; then
        echo "check-code.sh: launch of cs-check failed" ; exit 1;
    fi
}

echo "check-code.sh: Running PHP Code Sniffer..."
(cd /var/www && composer run-script phpcs) || { echo "check-code.sh: launch of phpcs failed" ; exit 1; }

echo "check-code.sh: Running PHPStan..."
(cd /var/www && composer run-script phpstan) || { echo "check-code.sh: launch of phpstan failed" ; exit 1; }

echo "check-code.sh: Running Rector..."
(cd /var/www && composer run-script rector-dry) || { echo "check-code.sh: launch of rector-dry failed" ; exit 1; }

echo "check-code.sh: All checks completed"
