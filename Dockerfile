FROM php:latest

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install zip pdo_mysql

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www

COPY . /var/www

RUN chmod -R 777 storage

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
EXPOSE 80
