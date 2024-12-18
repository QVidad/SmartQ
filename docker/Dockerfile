FROM php:7.4-fpm

RUN sed -i 's/9000/8701/' /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/ple-reapv3

ENV TZ=Asia/Manila

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y \
    curl \
    zip \
    unzip \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libzip-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-configure zip

RUN docker-php-ext-install pdo pdo_mysql gd zip
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/ple-reapv3

# Change current user to www
USER www

CMD ["php-fpm"]
