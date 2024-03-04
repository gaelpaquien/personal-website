#!/bin/bash

echo "build-docker.sh: Checking MySQL..."
/usr/local/bin/check-mysql.sh || { echo "build-docker.sh: launch of check-mysql.sh failed" ; exit 1; }

echo "build-docker.sh : Building App..."
/usr/local/bin/build-app.sh || { echo "build-docker.sh: launch of build-app.sh failed" ; exit 1; }

# echo "build-docker.sh : Building Database..."
# /usr/local/bin/build-database.sh || { echo "build-docker.sh: launch of build-database.sh failed" ; exit 1; }

echo "build-docker.sh: Starting Apache in the foreground..."
apachectl -DFOREGROUND || { echo "build-docker.sh: command "apachectl -DFOREGROUND" failed" ; exit 1; }
