#!/bin/bash

echo "build-app.sh: Installing composer dependencies..."
(cd /var/www && composer install) || { echo "build-app.sh: composer install failed" ; exit 1; }

echo "build-app.sh: Warmup cache..."
(cd /var/www && symfony console cache:warmup --env=dev) || { echo "build-app.sh: cache:warmup failed" ; exit 1; }
