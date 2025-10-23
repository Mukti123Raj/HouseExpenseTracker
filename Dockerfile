# 1. Base PHP Image
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# 2. Install System Dependencies
# Install Nginx, Supervisor, Git, and other build-time dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    postgresql-dev \ # For pgsql
    && docker-php-ext-install pdo pdo_pgsql zip bcmath \ # Install PHP extensions
    && rm -rf /var/cache/apk/*

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Install Node.js & NPM
RUN apk add --no-cache nodejs npm

# 5. Copy ALL Application Files
# This is the most important change. Copy everything first.
COPY . /var/www/html/

# 6. Set up a build-time .env file
# We need this for 'artisan' commands to run during the build.
# Render's variables will override this at runtime.
RUN cp .env.example .env
RUN php artisan key:generate --ansi

# 7. Install PHP & NPM Dependencies
# Now these commands will work because 'artisan' and 'package.json' exist.
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress
RUN npm install
RUN npm run build

# 8. Set Production Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Configure Nginx & Supervisor
COPY docker.nginx.conf /etc/nginx/http.d/default.conf
COPY docker.supervisord.conf /etc/supervisord.conf

# 10. Expose Port & Run
# Render connects to port 8080 by default for Nginx
EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]