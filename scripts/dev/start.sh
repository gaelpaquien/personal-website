#!/bin/bash
set -e

# Execute mysql-check script
echo "start.sh : Checking if mysql is running..."
/usr/local/bin/mysql-check.sh

# Execute app-build script
echo "start.sh : Building app..."
/usr/local/bin/app-build.sh

# Execute database-build script
echo "start.sh : Setting up database..."
/usr/local/bin/database-build.sh

# Starting apache
echo "start.sh : Starting apache in the foreground..."
apachectl -DFOREGROUND
