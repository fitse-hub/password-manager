@echo off
echo ========================================
echo   Docker Testing - Password Manager
echo ========================================
echo.

echo [Step 1/5] Checking Docker...
docker --version
if %errorlevel% neq 0 (
    echo ERROR: Docker is not installed!
    echo Please install Docker Desktop from: https://www.docker.com/products/docker-desktop
    pause
    exit /b 1
)
echo.

echo [Step 2/5] Preparing environment...
if exist .env.local (
    echo Backing up current .env to .env.local
    copy /Y .env .env.local >nul
)
echo Copying Docker environment...
copy /Y .env.docker .env >nul
echo.

echo [Step 3/5] Building and starting containers...
echo This may take a few minutes on first run...
docker compose up --build -d
if %errorlevel% neq 0 (
    echo ERROR: Failed to start containers!
    echo Check the error messages above.
    pause
    exit /b 1
)
echo.

echo [Step 4/5] Waiting for containers to be ready...
timeout /t 10 /nobreak >nul
echo.

echo [Step 5/5] Checking container status...
docker ps
echo.

echo ========================================
echo   Docker Testing Ready!
echo ========================================
echo.
echo Your application is running at:
echo   - Application: http://localhost:8000
echo   - phpMyAdmin: http://localhost:8080
echo.
echo Useful commands:
echo   docker logs -f password_manager_app     - View logs
echo   docker compose down                     - Stop containers
echo   docker exec password_manager_app php artisan [command]
echo.
echo Opening application...
start http://localhost:8000
echo.
echo Press any key to view logs (Ctrl+C to exit logs)...
pause >nul
docker logs -f password_manager_app
