# Use the official PHP image with Apache
FROM php:8.2-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite (optional, but often useful)
RUN a2enmod rewrite

# Copy all project files to the Apache web root
COPY . /var/www/html/

# Set recommended permissions (optional, for dev)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"] 