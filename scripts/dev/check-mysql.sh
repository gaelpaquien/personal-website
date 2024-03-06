#!/bin/bash

MAX_ATTEMPTS=50
ATTEMPTS=0

until nc -z -v -w30 database 3306; do
    echo "mysql-check.sh: Waiting MySQL to continue... (Attempt : $((ATTEMPTS + 1))/$MAX_ATTEMPTS)"
    sleep 10
    ((ATTEMPTS++))
    if [ $ATTEMPTS -eq $MAX_ATTEMPTS ]; then
        echo "mysql-check.sh: Failed to access MySQL after $ATTEMPTS attempts, exiting..."
        exit 1
    fi
done

echo "mysql-check.sh: OK -> MySQL is running"
