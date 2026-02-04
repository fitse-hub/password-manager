@echo off
echo ========================================
echo   Password Manager - Quick Test Script
echo ========================================
echo.

echo [1/6] Checking environment...
php -v
echo.

echo [2/6] Checking database connection...
php artisan db:show
echo.

echo [3/6] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo.

echo [4/6] Testing email configuration...
php artisan email:test
echo.

echo [5/6] Checking routes...
php artisan route:list --compact
echo.

echo [6/6] Opening application...
start http://localhost:8000
echo.

echo ========================================
echo   Quick Test Complete!
echo ========================================
echo.
echo Next Steps:
echo 1. Test registration at: http://localhost:8000/register
echo 2. Check email inbox for verification
echo 3. Test all features using LOCAL_TESTING_GUIDE.md
echo.
pause
