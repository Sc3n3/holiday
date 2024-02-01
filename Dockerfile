FROM alpine:3.18

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN echo 'https://dl-cdn.alpinelinux.org/alpine/edge/community' >> /etc/apk/repositories
RUN echo 'https://dl-cdn.alpinelinux.org/alpine/edge/main' >> /etc/apk/repositories

RUN apk -U upgrade && apk add --no-cache \
    git \
    zip \
    curl \
    nginx \
    gettext \
    nodejs \
    npm \
    unzip \
    tzdata \
    icu-data-full \
    supervisor \
    php82 \
    php82-common \
    php82-gd \
    php82-gmp \
    php82-fpm \
    php82-zip \
    php82-xml \
    php82-dom \
    php82-pdo \
    php82-phar \
    php82-curl \
    php82-exif \
    php82-ctype \
    php82-openssl \
    php82-mbstring \
    php82-fileinfo \
    php82-tokenizer \
    php82-pdo_mysql \
    php82-bcmath \
    php82-redis \
    php82-sodium \
    php82-mongodb \
    php82-xmlwriter \
    php82-pecl-amqp \
    && ln -s /usr/sbin/php-fpm82 /usr/sbin/php-fpm \
    #&& ln -s /usr/bin/php82 /usr/bin/php \
    && rm -rf /var/cache/apk/*

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./php-fpm.conf /etc/php82/php-fpm.d/www.conf
COPY ./supervisor.conf /etc/supervisor.d/workers.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN touch crontab.tmp \
    && echo '* * * * * php /var/www/html/artisan schedule:run' > crontab.tmp \
    && crontab crontab.tmp \
    && rm -rf crontab.tmp

WORKDIR /var/www/panel
ADD panel .

WORKDIR /var/www/html
ADD api .

RUN chmod -R 777 storage

RUN printf '#!/bin/sh\n\
\n\
set -e\n\
\n\
if [ "$APP_ENV" = "prod" ]; then\n\
    composer install --no-interaction --optimize-autoloader --no-dev\n\
else\n\
    composer install --no-interaction --optimize-autoloader\n\
fi\n\
cd /var/www/html && cp -n .env.example .env && php artisan migrate\n\
cd /var/www/panel && npm install && npm run build\n\
envsubst "\$API_DOMAIN \$PANEL_DOMAIN" < /etc/nginx/templates/nginx.conf.template > /etc/nginx/nginx.conf\n\
supervisord -n -c /etc/supervisord.conf\n\
' > /entrypoint.sh \
&& chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
