# 1. Base PHP Image
user www-data;
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# 2. Install System Dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    postgresql-dev \
    && rm -rf /var/cache/apk/*

# 3. Install PHP Extensions
RUN docker-php-ext-install pdo pdo_pgsql zip bcmath

# 4. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5. Install Node.js & NPM
RUN apk add --no-cache nodejs npm

# 6. Copy ALL Application Files
COPY . /var/www/html/

# 7. Install PHP Dependencies (WITHOUT scripts)
RUN composer install --no-dev --no-autoloader --no-scripts --no-interaction --no-progress

# 8. Create autoloader
RUN composer dump-autoload --optimize --no-scripts

# 9. Set up .env file and generate key
RUN cp .env.example .env
RUN php artisan key:generate --ansi

# 10. Run composer scripts (now that key exists)
RUN composer run-script post-autoload-dump --no-dev

# 11. Install NPM Dependencies
RUN npm install
RUN npm run build

# 12. Set Production Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 13. *** THIS IS THE MISSING FIX ***
#     Create the log directory for Supervisor
RUN mkdir -p /var/log/supervisor

# 14. Configure Nginx & Supervisor
COPY docker.nginx.conf /etc/nginx/http.d/default.conf
COPY docker.supervisord.conf /etc/supervisord.conf

# 15. Expose Port & Run
EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]