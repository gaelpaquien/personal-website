#!/bin/bash

SCRIPT_LABEL="build-app.sh"
APP_ENV="dev"
cd /var/www

echo "$SCRIPT_LABEL: Starting building app..."
symfony console cache:clear --env=$APP_ENV || exit 1
composer install || exit 1
composer dump-autoload --optimize || exit 1
symfony console importmap:install || exit 1
symfony console asset-map:compile || exit 1
symfony console cache:warmup --env=$APP_ENV || exit 1
symfony console presta:sitemaps:dump public --env=$APP_ENV || exit 1
echo "$SCRIPT_LABEL: Building app completed"

#echo "$SCRIPT_LABEL: Starting building database..."
#symfony console doctrine:database:create --if-not-exists --env=$APP_ENV || exit 1
#symfony console doctrine:migrations:migrate --no-interaction --env=$APP_ENV || exit 1
#symfony console doctrine:fixtures:load --no-interaction --env=$APP_ENV || exit 1
#echo "$SCRIPT_LABEL: Building database completed"

#echo "$SCRIPT_LABEL: Starting checking app..."
#symfony check:requirements || exit 1
#composer outdated || exit 1
#symfony check:security || exit 1
#symfony console debug:router || exit 1
#symfony console doctrine:schema:validate || exit 1
#echo "$SCRIPT_LABEL: Checking app completed"

#echo "$SCRIPT_LABEL: Starting checking code..."
#composer run-script cs-check || exit 1
#composer run-script phpcs || exit 1
#composer run-script phpstan || exit 1
#composer run-script rector-dry || exit 1
#symfony console lint:twig templates || exit 1
#symfony console lint:yaml config translations || exit 1
#echo "$SCRIPT_LABEL: Checking code completed"

# Sass en background
echo "$SCRIPT_LABEL: Starting Sass..."
sass --watch assets/styles/scss:assets/styles/css --style=compressed &
echo "$SCRIPT_LABEL: Sass is started"

echo "Build is completed. Let the container running..." && exec "$@"