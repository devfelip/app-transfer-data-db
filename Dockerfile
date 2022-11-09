FROM millenio/nginx-php-composer:php80

WORKDIR /usr/share/nginx/html

CMD composer update && chmod +x ./docker/script.sh && ./docker/script.sh && /start.sh