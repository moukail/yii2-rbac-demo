FROM php:8.2-fpm-alpine3.17
ENV TIMEZONE 'UTC'

RUN apk --update --no-cache add bash gcc g++ make nano autoconf linux-headers libzip-dev libpng-dev icu-dev libsodium-dev libxml2-dev \
    openssh git freetype

RUN docker-php-ext-install -j$(nproc) gd pdo_mysql zip intl bcmath soap sockets

RUN pecl install xdebug libsodium && docker-php-ext-enable opcache xdebug sodium soap

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /usr/local/etc/php/php.ini \
    && sed -i "s|memory_limit =.*|memory_limit = -1|" /usr/local/etc/php/php.ini

RUN echo $'zend_extension=xdebug.so \n\
xdebug.mode=debug \n\
xdebug.start_with_request=trigger \n\
xdebug.client_host=host.docker.internal'\
> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www

ADD docker-init.sh /home/
RUN chmod +x /home/docker-init.sh

CMD bash /home/docker-init.sh
