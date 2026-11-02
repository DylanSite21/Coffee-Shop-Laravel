# ==========================================
# Stage 1: Build Frontend Assets (Vite)
# ==========================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# ==========================================
# Stage 2: Install Composer Dependencies
# ==========================================
FROM php:8.3-cli-alpine AS vendor

WORKDIR /app

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Install PHP extension installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install extensions required by Laravel and database drivers
RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    curl \
    dom \
    fileinfo \
    xml \
    opcache

# Copy Composer definitions
COPY composer.json composer.lock ./

# Install production dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-autoloader \
    --no-scripts

# Copy application source
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload \
    --optimize \
    --no-dev \
    --no-scripts

# Discover Laravel packages
RUN php artisan package:discover --ansi


# ==========================================
# Stage 3: Production Container
# ==========================================
FROM php:8.3-fpm-alpine AS production

WORKDIR /var/www/html

# Install system packages
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    bash \
    su-exec

# Install PHP extension installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    curl \
    dom \
    fileinfo \
    xml \
    opcache

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Copy configuration files
COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

# Copy application source
COPY . /var/www/html

# Copy production dependencies
COPY --from=vendor /app/vendor /var/www/html/vendor

COPY --from=vendor /app/bootstrap/cache/ /var/www/html/bootstrap/cache/


# Copy built Vite assets
COPY --from=frontend /app/public/build /var/www/html/public/build

# Create Laravel runtime directories
RUN mkdir -p \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    && chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Render default port
EXPOSE 10000

# Health check
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -fsS http://127.0.0.1:${PORT:-10000}/up || exit 1

ENTRYPOINT ["/entrypoint.sh"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
