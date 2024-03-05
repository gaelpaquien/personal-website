#!/bin/bash

echo "build-database.sh: Creating database if not exists..."
(cd /var/www && symfony console doctrine:database:create --if-not-exists --env=dev) || { echo "build-database.sh: doctrine:database:create failed" ; exit 1; }

echo "build-database.sh: Applying migrations..."
(cd /var/www && symfony console doctrine:migrations:migrate --no-interaction --env=dev) || { echo "build-database.sh: doctrine:migrations:migrate failed" ; exit 1; }

echo "build-database.sh: Loading fixtures..."
(cd /var/www && symfony console doctrine:fixtures:load --no-interaction --env=dev) || { echo "build-database.sh: doctrine:fixtures:load failed" ; exit 1; }
