@echo off
echo ========================================
echo   Password Manager - Docker Deployment
echo ========================================
echo.

echo Checking Docker installation...
docker --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker is not installed!
    echo Please install Docker Desktop from: https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)

echo Docker is installed!
echo.

echo Building and starting containers...
echo This may take a few minutes on first run...
echo.

docker compose up --build -d

if errorlevel 1 (
    echo.
    echo ERROR: Failed to start containers!
    echo Check the error messages above.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   SUCCESS! Containers are running
echo ========================================
echo.
echo Your Password Manager is now available at:
echo   Application: http://localhost:8000
echo   phpMyAdmin:  http://localhost:8080
echo.
echo Database Credentials:
echo   Username: laravel
echo   Password: secret
echo.
echo Useful Commands:
echo   View logs:    docker compose logs -f app
echo   Stop:         docker compose down
echo   Restart:      docker compose restart
echo.
echo ========================================
pause
