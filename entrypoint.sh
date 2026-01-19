#!/bin/sh
set -e

echo "running entrypoint file"

cp -r /var/www/html/vendor/* ./vendor/

cd /var/www/html

if [[ ! -f .env ]]; then
    echo "Creating .env file"
    cp .env.example
    php artisan key:generate
else
    echo ".env file already exists"
fi

echo "starting migrations"
php artisan migrate
echo "ending migrations"

if [[ ! -f storage/oauth-private.key || ! -f storage/oauth-public.key ]]; then
    echo "starting passport keys"
    php artisan passport:keys
    echo "ending passport keys"

    echo "starting passport personal client token"
    php artisan passport:client --personal --name="CharacterCreationAPI Personal Access Client"
    echo "ending passport personal client token"
else
    echo "passport keys already exists so passport personal access client too"
fi

exec "$@"

