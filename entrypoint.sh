#!/bin/sh

echo "Waiting for mysql..."

while ! nc -z mysql 3306; do
  sleep 1
done

echo "Mysql launched"

env DB_HOST=mysql php artisan migrate

php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache

env DB_HOST=mysql php artisan db:seed

exec "$@"
