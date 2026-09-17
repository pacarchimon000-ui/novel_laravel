#!/bin/bash

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan cache:clear

# Link storage (if needed)
php artisan storage:link

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
