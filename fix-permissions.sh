#!/bin/bash

# Laravel Permissions Fix Script
# Run this from your project root: /home/jamaycom/public_html/parc.jamaycom.com

echo "Setting proper permissions for Laravel application..."

# Get the current user (should be jamaycom)
CURRENT_USER=$(whoami)
WEB_SERVER_USER="apache"  # Change to 'www-data' if using Apache on Ubuntu/Debian, or 'nginx' if using Nginx

# Set directory permissions (755 = rwxr-xr-x)
echo "Setting directory permissions..."
find . -type d -exec chmod 755 {} \;

# Set file permissions (644 = rw-r--r--)
echo "Setting file permissions..."
find . -type f -exec chmod 644 {} \;

# Make artisan executable
echo "Making artisan executable..."
chmod +x artisan

# Set permissions for storage and bootstrap/cache (Laravel needs write access)
echo "Setting write permissions for storage and bootstrap/cache..."
chmod -R 775 storage bootstrap/cache

# Fix ownership (adjust WEB_SERVER_USER if needed)
# Uncomment the line below if you need to change ownership
# chown -R $CURRENT_USER:$WEB_SERVER_USER storage bootstrap/cache

# Specifically ensure component files are readable
echo "Ensuring component files are readable..."
chmod 644 app/View/Components/Admin/App.php 2>/dev/null || echo "Admin/App.php not found"
chmod 644 app/View/Components/serviceTechnique/App.php 2>/dev/null || echo "serviceTechnique/App.php not found"

# Ensure all directories in app/View/Components are accessible
find app/View/Components -type d -exec chmod 755 {} \;
find app/View/Components -type f -exec chmod 644 {} \;

echo "Permissions fixed!"
echo ""
echo "Next steps:"
echo "1. Run: composer dump-autoload"
echo "2. Run: php artisan view:clear"
echo "3. Run: php artisan config:clear"
echo "4. Run: php artisan cache:clear"


