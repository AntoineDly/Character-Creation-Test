#!/bin/sh
set -e

cd /var/www/html

if [[ ! -f .env ]]; then
    echo "Creating .env file"
    cp .env.example
    php artisan key:generate
else
    echo ".env file already exists"
fi

exec tail -f /dev/null
