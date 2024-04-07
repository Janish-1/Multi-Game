# Use the official PHP image for PHP 8.0
FROM php:8.0

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
COPY . /var/www/html
RUN composer install --no-interaction --ignore-platform-req=ext-mongodb

# Set folder permissions if needed
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start PHP server (replace 'artisan' with your Laravel app's entrypoint)
CMD php artisan serve --host=0.0.0.0 --port=80
