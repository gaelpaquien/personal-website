#!/bin/bash

echo "build-database.sh: Creating database..."
(cd /var/www && php bin/console doctrine:database:create --if-not-exists --env=dev) || { echo "database-build.sh: doctrine:database:create failed" ; exit 1; }

echo "build-database.sh: Creating schema..."
(cd /var/www && php bin/console doctrine:schema:create --env=dev) || { echo "database-build.sh: doctrine:schema:create failed" ; exit 1; }

echo "build-database.sh: Loading fixtures..."
echo "yes" | (cd /var/www && php bin/console doctrine:fixtures:load --env=dev) || { echo "database-build.sh: doctrine:fixtures:load failed" ; exit 1; }
