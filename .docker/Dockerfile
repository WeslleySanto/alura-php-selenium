FROM php:7.4-apache
RUN apt-get update -y
RUN apt-get install -y \
    iputils-ping \
    libzip-dev \
    zip \
  && docker-php-ext-install zip
RUN a2enmod rewrite

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer