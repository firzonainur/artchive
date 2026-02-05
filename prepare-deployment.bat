@echo off
REM Deployment Preparation Script for Windows
REM Run this before uploading to shared hosting

echo.
echo ========================================
echo   Laravel Deployment Preparation
echo ========================================
echo.

REM Step 1: Install dependencies
echo [1/6] Installing Composer dependencies...
call composer install --optimize-autoloader --no-dev

REM Step 2: Build frontend assets
echo [2/6] Building frontend assets...
call npm install
call npm run build

REM Step 3: Clear all caches
echo [3/6] Clearing caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear

REM Step 4: Optimize for production
echo [4/6] Optimizing application...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache
call php artisan optimize

REM Step 5: Create production .env template
echo [5/6] Creating .env.production template...
copy .env .env.production.example
powershell -Command "(gc .env.production.example) -replace 'APP_ENV=local', 'APP_ENV=production' | Out-File -encoding ASCII .env.production.example"
powershell -Command "(gc .env.production.example) -replace 'APP_DEBUG=true', 'APP_DEBUG=false' | Out-File -encoding ASCII .env.production.example"
powershell -Command "(gc .env.production.example) -replace 'APP_URL=http://localhost', 'APP_URL=https://yourdomain.com' | Out-File -encoding ASCII .env.production.example"

REM Step 6: Instructions
echo [6/6] Creating deployment package...
echo.
echo ========================================
echo   Manual Steps Required:
echo ========================================
echo.
echo 1. Use 7-Zip or WinRAR to compress this folder
echo 2. Exclude these folders/files:
echo    - node_modules
echo    - .git
echo    - tests
echo    - storage/logs
echo    - .env (use .env.production.example instead)
echo.
echo 3. Upload the ZIP to your hosting
echo 4. Follow DEPLOYMENT_GUIDE.md for instructions
echo.
echo ========================================
echo   Preparation Complete!
echo ========================================
echo.
pause
