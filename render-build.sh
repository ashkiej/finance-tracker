#!/usr/bin/env bash
# .render-build.sh

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install and build frontend
npm install
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
