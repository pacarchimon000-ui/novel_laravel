#!/bin/bash

# Wait for the app to be ready
sleep 5

# Run queue worker
php artisan queue:work --tries=3 --timeout=90
