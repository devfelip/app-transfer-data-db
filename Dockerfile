FROM millenio/nginx-php-composer:php80

WORKDIR /usr/share/nginx/html

CMD composer update && ./docker/script.sh && /start.sh