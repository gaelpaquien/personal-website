#!/bin/bash

echo "build-docker.sh: Checking MySQL..."
/usr/local/bin/check-mysql.sh || { echo "build-docker.sh: launch of check-mysql.sh failed" ; exit 1; }

echo "build-docker.sh : Building App..."
/usr/local/bin/build-app.sh || { echo "build-docker.sh: launch of build-app.sh failed" ; exit 1; }

# echo "build-docker.sh : Building Database..."
# /usr/local/bin/build-database.sh || { echo "build-docker.sh: launch of build-database.sh failed" ; exit 1; }

echo "start-sass.sh: Starting Sass in the foreground..."
/usr/local/bin/start-sass.sh || { echo "start-sass.sh: launch of start-sass.sh failed" ; exit 1; }

echo "build-docker.sh: Starting Apache in the foreground..."
apachectl -DFOREGROUND || { echo "build-docker.sh: apachectl -DFOREGROUND failed" ; exit 1; }
