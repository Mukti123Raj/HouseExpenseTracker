# Use PHP 8.2 FPM Alpine as base image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    postgresql-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_pgsql \
    zip \
    bcmath \
    gd \
    intl \
    mbstring \
    xml

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js v20 and npm
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy package files
COPY package*.json ./

# Install Node dependencies
RUN npm ci --only=production

# Copy all project files
COPY . .

# Build frontend assets
RUN npm run build

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration
COPY docker.nginx.conf /etc/nginx/http.d/default.conf

# Copy Supervisor configuration
COPY docker.supervisord.conf /etc/supervisord.conf

# Create necessary directories
RUN mkdir -p /var/run/php-fpm \
    && mkdir -p /var/log/supervisor

# Expose port 8080
EXPOSE 8080

# Set the command to run supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
