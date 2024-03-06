#!/bin/bash

echo "fix-code.sh: Fixing code style with PHP-CS-Fixer..."
(cd /var/www && composer run-script cs-fix) || { echo "fix-code.sh: launch of cs-fix failed" ; exit 1; }

echo "fix-code.sh: Applying code refactorings with PHPCBF..."
(cd /var/www && composer run-script phpcbf) || { echo "fix-code.sh: launch of phpcbf failed" ; exit 1; }

echo "fix-code.sh: Applying code refactorings with Rector..."
(cd /var/www && composer run-script rector) || { echo "fix-code.sh: launch of rector failed" ; exit 1; }

echo "fix-code.sh: All fixes completed"
