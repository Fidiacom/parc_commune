# Testing Checklist - Items to Check and Fix

## 🔴 Critical Issues to Fix

### 1. Missing `create()` Method in MissionOrderController
**Issue**: Route `/admin/mission-order/create` exists but controller method is missing
**Location**: `app/Http/Controllers/Admin/MissionOrderController.php`
**Fix**: Add `create()` method that returns the create view
**Status**: ❌ Needs Fix

### 2. Driver Form Select2 Validation
**Issue**: Select2 dropdown for `permisType` may have form submission issues
**Location**: `resources/views/admin/drivers/create.blade.php`
**Check**: Verify Select2 properly submits array values
**Status**: ⚠️ Needs Verification

## 🟡 Important Items to Verify

### 3. CRUD Operations - UPDATE
**Test**: Verify UPDATE operations work for:
- ✅ Vehicles (tested via form)
- ⚠️ Drivers (needs manual test)
- ⚠️ Mission Orders (needs manual test)
- ⚠️ Payment Vouchers (needs manual test)

### 4. CRUD Operations - DELETE
**Test**: Verify DELETE operations work for:
- ⚠️ Vehicles
- ⚠️ Drivers
- ⚠️ Mission Orders
- ⚠️ Payment Vouchers

### 5. Mission Order Validation
**Issue**: Driver must have correct permis category for vehicle
**Location**: `app/Managers/MissionOrderManager.php` (line 46)
**Check**: Test error message when driver doesn't have required permis
**Status**: ⚠️ Needs Test

### 6. Payment Voucher Category-Specific Fields
**Test**: Verify required fields for each category:
- ✅ `carburant` - requires `fuel_liters` (tested)
- ⚠️ `rechange_pneu` - requires `tire_id` (needs test)
- ⚠️ `vidange` - requires `vidange_threshold_km` (needs test)
- ⚠️ `insurance` - requires `insurance_expiration_date` (needs test)
- ⚠️ `visite_technique` - requires `technical_visit_expiration_date` (needs test)

## 🟢 Good to Check

### 7. Form Validation Messages
**Check**: All validation error messages are user-friendly and translated
**Status**: ✅ Appears OK (needs manual verification)

### 8. Data Relationships
**Check**: 
- ✅ Vehicles ↔ Drivers (via mission orders)
- ✅ Vehicles ↔ Payment Vouchers
- ✅ Mission Orders relationships
**Status**: ✅ Verified

### 9. Dashboard Functionality
**Check**:
- ✅ Consumption alerts display correctly
- ✅ Vehicle alerts working
- ✅ Statistics display correctly
**Status**: ✅ Working

### 10. Print Functionality
**Check**:
- ✅ Mission order print route exists
- ⚠️ Verify print output is correct
**Status**: ⚠️ Needs Manual Verification

## 📋 Testing Priority

### High Priority (Fix Immediately)
1. Add missing `create()` method to MissionOrderController
2. Test driver form Select2 submission
3. Test UPDATE operations for all entities
4. Test DELETE operations for all entities

### Medium Priority (Test Soon)
5. Test mission order permis validation
6. Test payment voucher category-specific validations
7. Verify print functionality output

### Low Priority (Nice to Have)
8. Manual testing of all forms
9. Cross-browser testing
10. Mobile responsiveness testing

## 🔧 Quick Fixes Needed

### Fix 1: Add create() method to MissionOrderController
```php
public function create()
{
    $vehicules = $this->vehiculeService->getAllVehicules();
    $drivers = $this->driverService->getAllDrivers();

    return view('admin.mission_order.create', [
        'drivers' => $drivers,
        'vehicules' => $vehicules,
    ]);
}
```

**Note**: If the form is on the index page, you may need to remove the route or create the view.

