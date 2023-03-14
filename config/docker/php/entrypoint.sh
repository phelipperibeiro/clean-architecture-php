#!/bin/sh
#if [ ! -f ".env" ]; then
#  cp .env.example .env
#fi
chmod 777 ./storage/registrations
chmod 777 ./.env
composer install
php-fpm
