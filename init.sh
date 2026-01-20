#!/bin/sh
set -e

echo "running init file"

cd /var/www/html

php artisan cache:clear

echo "starting generate keys"
php artisan key:generate
echo "ending generate keys"

echo "starting migrations"
php artisan migrate:fresh
echo "ending migrations"

echo "starting remove oauth keys"
rm -rf storage/oauth-private.key
rm -rf storage/oauth-public.key
echo "ending remove oauth keys"

echo "starting passport keys"
php artisan passport:keys
echo "ending passport keys"

echo "starting passport personal client token"
php artisan passport:client --personal --name="CharacterCreationAPI Personal Access Client"
echo "ending passport personal client token"

echo "ending init file"
