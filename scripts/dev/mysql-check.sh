#!/bin/bash

max_attempts=10
attempts=0

until nc -z -v -w30 database 3306; do
    echo "mysql-check.sh: Waiting MySQL to continue..."
    sleep 6
    ((attempts++))
    if [ $attempts -eq $max_attempts ]; then
        echo "mysql-check.sh: Failed to access MySQL after $attempts attempts, exiting..."
        exit 1
    fi
done

echo "mysql-check.sh: OK -> MySQL is running"
