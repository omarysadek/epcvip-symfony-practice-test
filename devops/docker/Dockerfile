FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
    	libzip-dev \
    	wget \
        curl \
        wait-for-it \
        nano

RUN apt-get autoclean -y && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip  

RUN pecl install apcu

RUN docker-php-ext-enable apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN wget https://get.symfony.com/cli/installer -O - | bash

RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN groupadd -g 1000 www

RUN useradd -u 1000 -ms /bin/bash -g www www

USER www

WORKDIR /var/www
    
EXPOSE 9000

CMD ["php-fpm"]