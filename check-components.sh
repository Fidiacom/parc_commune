#!/bin/bash

# Component Diagnostic Script
# Run this on your server to check what's wrong

echo "=== Laravel Component Diagnostic ==="
echo ""

# Check if component files exist
echo "1. Checking component files..."
if [ -f "app/View/Components/Admin/App.php" ]; then
    echo "   ✓ app/View/Components/Admin/App.php EXISTS"
    ls -la app/View/Components/Admin/App.php
else
    echo "   ✗ app/View/Components/Admin/App.php MISSING"
fi

if [ -f "app/View/Components/Admin/app.php" ]; then
    echo "   ⚠ WARNING: app/View/Components/Admin/app.php (lowercase) EXISTS - DELETE THIS!"
    ls -la app/View/Components/Admin/app.php
fi

if [ -f "app/View/Components/serviceTechnique/App.php" ]; then
    echo "   ✓ app/View/Components/serviceTechnique/App.php EXISTS"
    ls -la app/View/Components/serviceTechnique/App.php
else
    echo "   ✗ app/View/Components/serviceTechnique/App.php MISSING"
fi

if [ -f "app/View/Components/serviceTechnique/app.php" ]; then
    echo "   ⚠ WARNING: app/View/Components/serviceTechnique/app.php (lowercase) EXISTS - DELETE THIS!"
    ls -la app/View/Components/serviceTechnique/app.php
fi

echo ""
echo "2. Checking AppServiceProvider..."
if grep -q "Blade::component.*admin.app" app/Providers/AppServiceProvider.php; then
    echo "   ✓ Component registration found in AppServiceProvider"
else
    echo "   ✗ Component registration NOT found in AppServiceProvider"
fi

echo ""
echo "3. Checking autoloader..."
if [ -f "vendor/composer/autoload_classmap.php" ]; then
    if grep -q "App\\\\View\\\\Components\\\\Admin\\\\App" vendor/composer/autoload_classmap.php; then
        echo "   ✓ Component class found in autoloader"
    else
        echo "   ✗ Component class NOT in autoloader - RUN: composer dump-autoload"
    fi
else
    echo "   ✗ Autoloader file not found"
fi

echo ""
echo "4. Testing if PHP can find the class..."
php -r "require 'vendor/autoload.php'; if (class_exists('App\\View\\Components\\Admin\\App')) { echo '   ✓ PHP can load the class\n'; } else { echo '   ✗ PHP CANNOT load the class\n'; }"

echo ""
echo "=== Diagnostic Complete ==="

