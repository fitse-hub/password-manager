@echo off
echo ========================================
echo   Deployment Sanity Check
echo ========================================
echo.

echo [1/8] Checking Apache Configuration...
docker exec password_manager_app cat /etc/apache2/sites-available/000-default.conf | findstr /C:"DocumentRoot /var/www/html/public" >nul
if %errorlevel% equ 0 (
    echo   ✅ DocumentRoot: CORRECT
) else (
    echo   ❌ DocumentRoot: WRONG
)

docker exec password_manager_app cat /etc/apache2/sites-available/000-default.conf | findstr /C:"AllowOverride All" >nul
if %errorlevel% equ 0 (
    echo   ✅ AllowOverride: CORRECT
) else (
    echo   ❌ AllowOverride: MISSING
)
echo.

echo [2/8] Checking APP_KEY...
docker exec password_manager_app php artisan tinker --execute="echo config('app.key') ? 'SET' : 'MISSING';" 2>nul | findstr "SET" >nul
if %errorlevel% equ 0 (
    echo   ✅ APP_KEY: SET
) else (
    echo   ❌ APP_KEY: MISSING - CRITICAL!
)
echo.

echo [3/8] Checking Environment...
docker exec password_manager_app php artisan tinker --execute="echo config('app.env');" 2>nul
docker exec password_manager_app php artisan tinker --execute="echo 'APP_DEBUG: ' . (config('app.debug') ? 'true' : 'false');" 2>nul
echo.

echo [4/8] Checking Database Connection...
docker exec password_manager_app php artisan db:show 2>nul
if %errorlevel% equ 0 (
    echo   ✅ Database: CONNECTED
) else (
    echo   ❌ Database: CONNECTION FAILED
)
echo.

echo [5/8] Checking File Permissions...
docker exec password_manager_app test -w /var/www/html/storage
if %errorlevel% equ 0 (
    echo   ✅ storage/: WRITABLE
) else (
    echo   ❌ storage/: NOT WRITABLE
)
echo.

echo [6/8] Checking for Errors in Logs...
docker logs password_manager_app --tail 20 | findstr /I "error fatal exception" >nul
if %errorlevel% equ 0 (
    echo   ⚠️  Errors found in logs - check details
) else (
    echo   ✅ No errors in recent logs
)
echo.

echo [7/8] Testing Email Configuration...
docker exec password_manager_app php artisan email:test 2>nul
if %errorlevel% equ 0 (
    echo   ✅ Email: CONFIGURED
) else (
    echo   ⚠️  Email: CHECK CONFIGURATION
)
echo.

echo [8/8] Testing Application...
curl -s -o nul -w "HTTP Status: %%{http_code}" http://localhost:8000
echo.
echo.

echo ========================================
echo   Sanity Check Complete
echo ========================================
echo.
echo Next Steps:
echo 1. Review any ❌ or ⚠️  items above
echo 2. Fix issues before deploying
echo 3. Read: DEPLOYMENT_SANITY_CHECKLIST.md
echo.
pause
