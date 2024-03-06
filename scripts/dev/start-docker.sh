#!/bin/bash

ROOT_PATH="$(dirname "$(dirname "$(dirname "$(realpath "$0")")")")"

echo "start.sh: Building SSL certificate..."
chmod +x "$ROOT_PATH/scripts/dev/build-ssl-certificate.sh"
"$ROOT_PATH/scripts/dev/build-ssl-certificate.sh" || { echo "start.sh: launch of build-ssl-certificate.sh failed" ; exit 1; }

echo "start.sh: Building Docker..."
if ! command -v docker-compose &> /dev/null; then
    echo "start.sh: docker-compose is not installed, aborting."
    exit 1
fi

docker-compose build || { echo "start.sh: docker-compose build failed" ; exit 1; }
docker-compose up || { echo "start.sh: docker-compose up failed" ; exit 1; }
