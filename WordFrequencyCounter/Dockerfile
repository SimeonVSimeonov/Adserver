# Use an official PHP image with PHP-FPM
FROM php:7.4-fpm

# Install necessary PHP extensions, including Redis
RUN apt-get update && apt-get install -y libssl-dev && \
    pecl install redis && \
    docker-php-ext-enable redis

# Set the working directory inside the container
WORKDIR /var/www

# Copy the project files into the container
COPY . /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000
