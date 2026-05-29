#!/bin/bash

echo "=== Starting Class Schedule App ==="

# Detect Railway public URL
RAILWAY_URL="${RAILWAY_STATIC_URL:-${RAILWAY_PUBLIC_DOMAIN:-${RAILWAY_DOMAIN:-}}}"
if [ -n "$RAILWAY_URL" ]; then
    RAILWAY_URL="${RAILWAY_URL#https://}"
    RAILWAY_URL="${RAILWAY_URL#http://}"
    export APP_URL="https://$RAILWAY_URL"
    echo "APP_URL set to: $APP_URL"
fi

# Copy .env if missing
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || touch .env
    echo "Created .env file"
fi

# Generate APP_KEY
php artisan key:generate --force 2>/dev/null || true
echo "APP_KEY ready"

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Cache config (non-fatal if it fails)
php artisan config:cache 2>/dev/null || true

# Run migrations (non-fatal if it fails — allows app to start without DB)
php artisan migrate --force 2>/dev/null || echo "Warning: migrations skipped (DB not ready)"

echo "=== Server starting on port ${PORT:-8080} ==="
exec php -S 0.0.0.0:${PORT:-8080} -t /var/www/html/public
