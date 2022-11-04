FROM millenio/nginx-php-composer:php80
WORKDIR /usr/share/nginx/html

CMD composer update && php artisan config:clear && php artisan key:generate && /start.sh