# Component Deployment Fix Guide

## Problem
Laravel can't find `App\View\Components\Admin\App` class on the server.

## Root Causes
1. File doesn't exist on server (still has lowercase `app.php`)
2. Autoloader hasn't been regenerated
3. Old lowercase files still exist

## Step-by-Step Fix

### Step 1: Check what files exist on server
```bash
cd /home/jamaycom/public_html/parc.jamaycom.com

# Check if correct files exist
ls -la app/View/Components/Admin/App.php
ls -la app/View/Components/serviceTechnique/App.php

# Check if old lowercase files exist (DELETE THESE!)
ls -la app/View/Components/Admin/app.php
ls -la app/View/Components/serviceTechnique/app.php
```

### Step 2: If files don't exist, create them

**Create Admin/App.php:**
```bash
cat > app/View/Components/Admin/App.php << 'EOF'
<?php

namespace App\View\Components\Admin;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $logoUrl;
    public string $mainColor;
    public ?string $secondColor;

    public function __construct(SettingService $settingService)
    {
        $this->logoUrl = $settingService->getLogoUrl();
        $this->mainColor = $settingService->getMainColor();
        $this->secondColor = $settingService->getSecondColor();
    }

    public function render(): View|Closure|string
    {
        return view('layouts.admin.app');
    }
}
EOF
```

**Create serviceTechnique/App.php:**
```bash
cat > app/View/Components/serviceTechnique/App.php << 'EOF'
<?php

namespace App\View\Components\serviceTechnique;

use App\Services\SettingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public string $logoUrl;
    public string $communeName;
    public string $mainColor;
    public ?string $secondColor;

    public function __construct(SettingService $settingService)
    {
        $this->logoUrl = $settingService->getLogoUrl();
        $this->communeName = $settingService->getCommuneName();
        $this->mainColor = $settingService->getMainColor();
        $this->secondColor = $settingService->getSecondColor();
    }

    public function render(): View|Closure|string
    {
        return view('layouts.service-technique.app');
    }
}
EOF
```

### Step 3: Delete old lowercase files (CRITICAL!)
```bash
rm -f app/View/Components/Admin/app.php
rm -f app/View/Components/serviceTechnique/app.php
```

### Step 4: Verify AppServiceProvider has registration
```bash
grep -A 5 "Blade::component" app/Providers/AppServiceProvider.php
```

If it doesn't show the registration, update it:
```bash
# Backup first
cp app/Providers/AppServiceProvider.php app/Providers/AppServiceProvider.php.bak

# The boot method should contain:
# Blade::component('admin.app', \App\View\Components\Admin\App::class);
# Blade::component('serviceTechnique.app', \App\View\Components\serviceTechnique\App::class);
```

### Step 5: Regenerate autoloader (CRITICAL!)
```bash
composer dump-autoload
```

### Step 6: Clear all caches
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

### Step 7: Fix permissions
```bash
chmod 644 app/View/Components/Admin/App.php
chmod 644 app/View/Components/serviceTechnique/App.php
chmod -R 755 app/View/Components
```

### Step 8: Verify
```bash
# Test if PHP can find the class
php -r "require 'vendor/autoload.php'; var_dump(class_exists('App\\View\\Components\\Admin\\App'));"
# Should output: bool(true)
```

## Quick One-Liner Fix (if files exist but autoloader is stale)
```bash
composer dump-autoload && php artisan view:clear && php artisan config:clear && php artisan cache:clear
```


