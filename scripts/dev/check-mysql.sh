#!/bin/bash

MAX_ATTEMPTS=50
ATTEMPTS=0
SCRIPT_LABEL="check-mysql.sh"

until nc -z -v -w30 mysql 3306; do
    echo "$SCRIPT_LABEL: Waiting MySQL to continue... (Attempt : $((ATTEMPTS + 1))/$MAX_ATTEMPTS)"
    sleep 10
    ((ATTEMPTS++))
    if [ $ATTEMPTS -eq $MAX_ATTEMPTS ]; then
        echo "$SCRIPT_LABEL: Failed to access MySQL after $ATTEMPTS attempts, exiting..."
        exit 1
    fi
done

echo "$SCRIPT_LABEL: OK -> MySQL is running and accepting connections"
