#!/bin/bash

# Exit on error
set -e

echo "🚀 Starting Password Manager Application..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until php artisan db:show 2>/dev/null; do
    echo "MySQL is unavailable - sleeping"
    sleep 2
done

echo "✅ MySQL is ready!"

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "⚙️ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "✅ Application is ready!"

# Start Apache
exec apache2-foreground
