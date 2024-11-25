#!/bin/bash

source functions.sh

SCRIPT_LABEL="build-docker.sh"

echo "$SCRIPT_LABEL: Starting building docker..."
execute_command "$SCRIPT_LABEL" "Start the script to checking MySQL" 0 "/usr/local/bin" ./check-mysql.sh
execute_command "$SCRIPT_LABEL" "Start the script to building app" 0 "/usr/local/bin" ./build-app.sh
execute_command "$SCRIPT_LABEL" "Start the script to checking app" 0 "/usr/local/bin" ./check-app.sh
execute_command "$SCRIPT_LABEL" "Start the script to checking code" 0 "/usr/local/bin" ./check-code.sh
# execute_command "$SCRIPT_LABEL" "Start the script to building database" 0 "/usr/local/bin" ./build-database.sh
echo "$SCRIPT_LABEL: Building docker completed"

execute_command "$SCRIPT_LABEL" "Starting Sass in the foreground" 0 "/var/www" sass --watch assets/styles/scss:assets/styles/css --style=compressed
execute_command "$SCRIPT_LABEL" "Starting PHP-FPM" 0 "/var/www" php-fpm &
execute_command "$SCRIPT_LABEL" "Starting Nginx" 0 "/var/www" nginx -g "daemon off;"
