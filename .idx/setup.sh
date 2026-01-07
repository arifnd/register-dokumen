#!/bin/bash

composer install

cp .env.example .env

php artisan key:generate

sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env

sed -i "s|DB_DATABASE=laravel|DB_DATABASE=$(pwd)/database/database.sqlite|" .env

php artisan migrate --seed --force