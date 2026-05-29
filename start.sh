#!/bin/bash

echo "=== Starting Class Schedule App ==="

# Detect Railway public URL
RAILWAY_URL="${RAILWAY_STATIC_URL:-${RAILWAY_PUBLIC_DOMAIN:-${RAILWAY_DOMAIN:-}}}"
if [ -n "$RAILWAY_URL" ]; then
    RAILWAY_URL="${RAILWAY_URL#https://}"
    RAILWAY_URL="${RAILWAY_URL#http://}"
    export APP_URL="https://$RAILWAY_URL"
    echo "APP_URL set to: $APP_URL"
else
    echo "No Railway URL env detected, trusting AppServiceProvider to use request host"
fi

# Use cookie session driver on Railway (avoids ephemeral filesystem issues)
export SESSION_DRIVER="cookie"
export SESSION_SECURE_COOKIE="true"

# Copy .env if missing
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || touch .env
    echo "Created .env file"
fi

# Only generate APP_KEY if not already set (never regenerate — breaks all sessions!)
if [ -z "$APP_KEY" ] && ! grep -q "^APP_KEY=" .env 2>/dev/null; then
    php artisan key:generate --force 2>/dev/null || true
    echo "APP_KEY generated"
else
    echo "APP_KEY already set, keeping existing key"
fi

# Storage link — remove directory first so storage:link can create a real symlink
if [ -d /var/www/html/public/storage ] && [ ! -L /var/www/html/public/storage ]; then
    rm -rf /var/www/html/public/storage
    echo "Removed public/storage directory to recreate as symlink"
fi
mkdir -p /var/www/html/storage/app/public/avatars
php artisan storage:link --force 2>/dev/null || true
echo "Storage link ready"

# Cache config (non-fatal)
php artisan config:cache 2>/dev/null || true

# Run migrations (non-fatal)
php artisan migrate --force 2>/dev/null || echo "Warning: migrations skipped"

echo "=== Server starting on port ${PORT:-8080} ==="
exec php -S 0.0.0.0:${PORT:-8080} -t /var/www/html/public
