#!/bin/bash

# Set APP_URL dynamically on Railway (before config:cache)
if [ -n "$RAILWAY_STATIC_URL" ]; then
    export APP_URL="https://$RAILWAY_STATIC_URL"
fi

# Generate APP_KEY if not set
php artisan key:generate --force

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache config for performance
php artisan config:cache 2>/dev/null || true

# Run database migrations
php artisan migrate --force

# Start PHP built-in server
php -S 0.0.0.0:${PORT:-8080} -t /var/www/html/public
