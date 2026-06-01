FROM php:8.2-apache

# Enable mysqli
RUN docker-php-ext-install mysqli

# Copy project files
COPY . /var/www/html/

# Enable Apache rewrite
RUN a2enmod rewrite

EXPOSE 80
