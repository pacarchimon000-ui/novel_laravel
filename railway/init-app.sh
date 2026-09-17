#!/bin/bash
set -e

echo "🚀 Starting initialization..."

# Generate APP_KEY if needed
if [ -z "$APP_KEY" ]; then
    echo "⚙️  Generating APP_KEY..."
    php artisan key:generate --force
fi

# Clear old cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force --no-interaction

# Link storage
echo "📁 Linking storage..."
php artisan storage:link || true

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Initialization complete!"
