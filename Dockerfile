FROM kmdr7/webstack:7.4

COPY --from=composer:2 /usr/bin/composer /usr/bin/

RUN apk -U --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community add \
        php-bcmath \
        php-cli \
        php-ctype \
        php-curl \
        php-dom \
        php-fileinfo \
        php-gd \
        php-iconv \
        php-intl \
        php-json \
        php-mbstring \
        php7-mongodb \
        php-openssl \
        php-opcache \
        php-pdo_mysql \
        php-pdo_pgsql \
        php-phar \
        php-session \
        php-simplexml \
        php-tokenizer \
        php-xml \
        php-xmlreader \
        php-xmlwriter \
        php-zip

COPY composer.json composer.lock /www/
COPY database /www/database

RUN composer install --no-dev --no-scripts --no-progress

COPY --chown=php:nginx . /www

RUN composer dump-autoload

RUN php artisan route:clear \
    && php artisan view:clear \
    && php artisan storage:link

RUN rm -rf /usr/bin/composer

EXPOSE 80
