# Use an official PHP image with PHP-FPM
FROM php:7.4-fpm

# Install any required PHP extensions (you can add more as needed)
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory inside the container
WORKDIR /var/www

# Copy the project files into the container
COPY . /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000
