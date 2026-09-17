#!/bin/bash

# Run Laravel scheduler every minute
while true; do
    php artisan schedule:run --verbose --no-interaction >> /dev/null 2>&1
    sleep 60
done
