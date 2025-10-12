FROM php:8.1-apache

# Copy app to apache document root
COPY . /var/www/html/

# Ensure data folder writable by www-data
RUN chown -R www-data:www-data /var/www/html/data && chmod -R 755 /var/www/html/data

EXPOSE 80
