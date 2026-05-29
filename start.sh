#!/bin/bash
set -e

echo "=== Starting Class Schedule App ==="

# Detect Railway public URL (try multiple variable names)
RAILWAY_URL="${RAILWAY_STATIC_URL:-${RAILWAY_PUBLIC_DOMAIN:-${RAILWAY_DOMAIN:-}}}"
if [ -n "$RAILWAY_URL" ]; then
    # Strip protocol if accidentally included
    RAILWAY_URL="${RAILWAY_URL#https://}"
    RAILWAY_URL="${RAILWAY_URL#http://}"
    export APP_URL="https://$RAILWAY_URL"
    echo "APP_URL set to: $APP_URL"
else
    echo "No Railway URL detected, using APP_URL from environment: ${APP_URL:-http://localhost}"
fi

# Generate APP_KEY if not set
php artisan key:generate --force
echo "APP_KEY generated"

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true
echo "Storage link created"

# Cache config for performance
php artisan config:cache || echo "Warning: config:cache failed (non-fatal)"
echo "Config cached"

# Run database migrations
echo "Running migrations..."
php artisan migrate --force
echo "Migrations complete"

# Start PHP built-in server
echo "Starting server on port ${PORT:-8080}..."
php -S 0.0.0.0:${PORT:-8080} -t /var/www/html/public
