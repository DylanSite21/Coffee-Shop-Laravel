#!/bin/sh
set -e

# Configure port in Nginx config
PORT="${PORT:-80}"
sed -i "s/__PORT__/${PORT}/g" /etc/nginx/http.d/default.conf

# Set permissions for Laravel directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink if not already present
if [ ! -L /var/www/html/public/storage ]; then
    php artisan storage:link || true
fi

# Run database migrations if AUTORUN_MIGRATIONS is true
if [ "${AUTORUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force || echo "Migration skipped or database not ready."
fi

# Cache configurations in production if APP_KEY is provided
if [ "${APP_ENV}" = "production" ] && [ -n "${APP_KEY}" ]; then
    echo "Caching configuration and routes..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Execute passed command (supervisord)
exec "$@"
