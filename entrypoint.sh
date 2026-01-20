#!/bin/sh
set -e

echo "running entrypoint file"

cd /var/www/html

if [[ ! -f .env ]]; then
    echo "Creating .env file"
    cp .env.example
else
    echo ".env file already exists"
fi

echo "ending entrypoint file"

exec "$@"

