#!/bin/sh

cd ../

php artisan down

git reset --hard
git pull --strategy-option=theirs --no-edit

export COMPOSER_HOME='/tmp/composer'
composer install --no-interaction --no-dev --prefer-dist

php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan -v queue:restart
php artisan migrate --force
php artisan up