#!/bin/sh

set -e

echo "Starting Laravel application..."

# ==========================================
# Configure Render Port
# ==========================================

PORT="${PORT:-10000}"

sed -i "s/__PORT__/${PORT}/g" /etc/nginx/http.d/default.conf

echo "Nginx configured on port ${PORT}"

# ==========================================
# Prepare Laravel Directories
# ==========================================

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

chmod -R 775 storage bootstrap/cache

# ==========================================
# Storage Symlink
# ==========================================

if [ ! -e public/storage ] && [ ! -L public/storage ]; then
    php artisan storage:link
fi

# ==========================================
# Database Migration
# ==========================================

if [ "${AUTORUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Running database migrations..."

    php artisan migrate --force

    echo "Database migrations completed."
fi

# ==========================================
# Laravel Production Cache
# ==========================================

if [ "${APP_ENV:-}" = "production" ]; then
    echo "Optimizing Laravel..."

    php artisan config:cache
    php artisan view:cache
fi

# ==========================================
# Start Supervisor
# ==========================================

echo "Starting Supervisor..."

exec "$@"
