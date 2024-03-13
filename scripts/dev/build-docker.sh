#!/bin/bash

source functions.sh

SCRIPT_LABEL="build-docker.sh"

echo "$SCRIPT_LABEL: Starting building docker..."
execute_command "$SCRIPT_LABEL" "Start the script to checking MySQL" 0 "/usr/local/bin" ./check-mysql.sh
execute_command "$SCRIPT_LABEL" "Start the script to building app" 0 "/usr/local/bin" ./build-app.sh
# execute_command "$SCRIPT_LABEL" "Start the script to building database" 0 "/usr/local/bin" ./build-database.sh
echo "$SCRIPT_LABEL: Building docker completed"

echo "start-sass.sh: Starting Sass in the foreground..."
(cd /var/www && sass --watch assets/styles/scss:assets/styles/css --style=compressed &)

echo "build-docker.sh: Starting Apache in the foreground..."
apachectl -DFOREGROUND || { echo "$SCRIPT_LABEL: apachectl -DFOREGROUND failed" ; exit 1; }
