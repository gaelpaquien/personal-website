#!/bin/bash

echo "app-build.sh: Installing composer dependencies..."
(cd /var/www && composer install) || { echo "app-build.sh: composer install failed" ; exit 1; }

echo "app-build.sh: Warmup cache..."
(cd /var/www && php bin/console cache:warmup --env=dev) || { echo "app-build.sh: cache:warmup failed" ; exit 1; }
