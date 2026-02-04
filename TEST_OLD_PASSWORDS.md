# Testing Old Passwords Detection

## Quick Test Guide

### Method 1: Using Existing Credentials
1. Navigate to Password Health page: `/password-health`
2. Check the "Old Passwords" stat card
3. If you have credentials older than 90 days, they will appear

### Method 2: Create Test Data (Manual)
If you want to test with specific data:

#### Option A: Using Tinker
```bash
php artisan tinker
```

```php
// Get a credential
$credential = App\Models\Credential::first();

// Set it to 100 days old
$credential->password_updated_at = now()->subDays(100);
$credential->save();

// Check the result
echo "Password age: " . $credential->password_updated_at->diffInDays(now()) . " days";
```

#### Option B: Using Database Query
```sql
-- Update first credential to be 100 days old
UPDATE credentials 
SET password_updated_at = DATE_SUB(NOW(), INTERVAL 100 DAY)
WHERE id = 1;

-- Update second credential to be 50 days old (should NOT appear)
UPDATE credentials 
SET password_updated_at = DATE_SUB(NOW(), INTERVAL 50 DAY)
WHERE id = 2;

-- Update third credential to be 150 days old
UPDATE credentials 
SET password_updated_at = DATE_SUB(NOW(), INTERVAL 150 DAY)
WHERE id = 3;
```

### Method 3: Check Current Data
```bash
php artisan tinker
```

```php
// Check all credentials and their ages
$credentials = App\Models\Credential::all();

foreach ($credentials as $cred) {
    $age = $cred->password_updated_at 
        ? $cred->password_updated_at->diffInDays(now())
        : $cred->created_at->diffInDays(now());
    
    echo "{$cred->website_name}: {$age} days old\n";
}
```

## Expected Results

### Scenario 1: Fresh Passwords (< 90 days)
```
Password Health Dashboard
├── Old Passwords: 0
└── No old passwords section displayed
```

### Scenario 2: Some Old Passwords (>= 90 days)
```
Password Health Dashboard
├── Old Passwords: 2
└── Old Passwords Section:
    ├── GitHub (120 days old)
    └── Facebook (95 days old)
```

### Scenario 3: All Old Passwords
```
Password Health Dashboard
├── Old Passwords: 5
├── Health Score: Low (< 60%)
└── Old Passwords Section:
    ├── GitHub (120 days)
    ├── Facebook (95 days)
    ├── Gmail (150 days)
    ├── Twitter (200 days)
    └── LinkedIn (100 days)
```

## Verification Checklist

- [ ] Old Passwords stat shows correct count
- [ ] Old passwords section appears when count > 0
- [ ] Each old password shows website name
- [ ] Days since update is displayed correctly
- [ ] Exact date is shown
- [ ] Warning message appears
- [ ] "Update Now" link works
- [ ] Health score reflects old passwords
- [ ] No errors in console/logs

## Common Test Cases

### Test Case 1: Exactly 90 Days
```php
$credential->password_updated_at = now()->subDays(90);
// Expected: Should appear in old passwords list
```

### Test Case 2: 89 Days (Just Under)
```php
$credential->password_updated_at = now()->subDays(89);
// Expected: Should NOT appear in old passwords list
```

### Test Case 3: Null password_updated_at
```php
$credential->password_updated_at = null;
$credential->created_at = now()->subDays(100);
// Expected: Should use created_at and appear in list
```

### Test Case 4: Very Old (1 Year)
```php
$credential->password_updated_at = now()->subDays(365);
// Expected: Should appear with "365 days ago"
```

## Reset Test Data

To reset credentials back to current date:
```sql
UPDATE credentials 
SET password_updated_at = NOW();
```

Or using Tinker:
```php
App\Models\Credential::query()->update(['password_updated_at' => now()]);
```

## Status
Ready for testing! Follow the methods above to verify old passwords detection is working correctly.
