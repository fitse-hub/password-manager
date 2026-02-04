@echo off
echo ========================================
echo   Stopping Password Manager Containers
echo ========================================
echo.

docker compose down

if errorlevel 1 (
    echo.
    echo ERROR: Failed to stop containers!
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Containers stopped successfully!
echo ========================================
echo.
echo To start again, run: docker-start.bat
echo.
pause
