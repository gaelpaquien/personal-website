#!/bin/bash

echo "build-app.sh: Installing composer dependencies..."
(cd /var/www && composer install) || { echo "app-build.sh: composer install failed" ; exit 1; }

echo "build-app.sh: Warmup cache..."
(cd /var/www && php bin/console cache:warmup --env=dev) || { echo "app-build.sh: cache:warmup failed" ; exit 1; }
