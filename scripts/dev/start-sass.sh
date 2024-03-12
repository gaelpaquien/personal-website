#!/bin/bash

echo "start-sass.sh: Running Sass watch..."
(cd /var/www && sass --watch assets/styles/scss:assets/styles/css --style=compressed &)
