#!/bin/bash

ROOT_PATH="$(dirname "$(dirname "$(dirname "$(realpath "$0")")")")"
SCRIPT_LABEL="start-docker.sh"

echo "$SCRIPT_LABEL: Building SSL certificate..."
chmod +x "$ROOT_PATH/scripts/dev/build-ssl-certificate.sh"
"$ROOT_PATH/scripts/dev/build-ssl-certificate.sh" || { echo "$SCRIPT_LABEL: launch of build-ssl-certificate.sh failed" ; exit 1; }

echo "$SCRIPT_LABEL: Building Docker..."
if ! command -v docker-compose &> /dev/null; then
    echo "$SCRIPT_LABEL: docker-compose is not installed, aborting"
    exit 1
fi

docker-compose build || { echo "$SCRIPT_LABEL: docker-compose build failed" ; exit 1; }
docker-compose up || { echo "$SCRIPT_LABEL: docker-compose up failed" ; exit 1; }
