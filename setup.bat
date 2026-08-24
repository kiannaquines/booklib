@echo off
setlocal enabledelayedexpansion
echo ==^> Checking requirements

where php >nul 2>nul
if errorlevel 1 (
  echo PHP is not installed or not in PATH. Install PHP 8.2+ first.
  exit /b 1
)

where composer >nul 2>nul
if errorlevel 1 (
  echo Composer is not installed or not in PATH. Install it first: https://getcomposer.org
  exit /b 1
)

where node >nul 2>nul
if errorlevel 1 (
  echo Node.js is not installed or not in PATH. Install it first.
  exit /b 1
)

where npm >nul 2>nul
if errorlevel 1 (
  echo npm is not installed or not in PATH. Install it first.
  exit /b 1
)

echo ==^> Installing PHP dependencies
call composer install --no-interaction --prefer-dist
if errorlevel 1 exit /b 1

echo ==^> Installing Node dependencies
call npm install
if errorlevel 1 exit /b 1

if not exist .env (
  echo ==^> Creating .env from .env.example
  copy .env.example .env >nul
) else (
  echo ==^> .env already exists, skipping copy
)

echo ==^> Generating application key
call php artisan key:generate

findstr /C:"DB_CONNECTION=sqlite" .env >nul
if not errorlevel 1 (
  if not exist database mkdir database
  if not exist database\database.sqlite (
    echo ==^> Creating SQLite database file
    type nul > database\database.sqlite
  )
)

echo ==^> Running database migrations
call php artisan migrate --force

echo ==^> Creating storage symlink
call php artisan storage:link

echo ==^> Building frontend assets
call npm run build

echo.
echo Setup complete! Start the app with:
echo   php artisan serve
echo   npm run dev   (in a separate terminal, for hot reload)
