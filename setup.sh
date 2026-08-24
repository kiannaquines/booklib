#!/usr/bin/env bash
# One-time project setup script for macOS/Linux
set -e

echo "==> Checking requirements"
command -v php >/dev/null 2>&1 || { echo "PHP is not installed. Install PHP 8.2+ first."; exit 1; }
command -v composer >/dev/null 2>&1 || { echo "Composer is not installed. Install it first: https://getcomposer.org"; exit 1; }
command -v node >/dev/null 2>&1 || { echo "Node.js is not installed. Install it first."; exit 1; }
command -v npm >/dev/null 2>&1 || { echo "npm is not installed. Install it first."; exit 1; }

echo "==> Installing PHP dependencies"
composer install --no-interaction --prefer-dist

echo "==> Installing Node dependencies"
npm install

if [ ! -f .env ]; then
  echo "==> Creating .env from .env.example"
  cp .env.example .env
else
  echo "==> .env already exists, skipping copy"
fi

echo "==> Generating application key"
php artisan key:generate

if grep -q '^DB_CONNECTION=sqlite' .env; then
  mkdir -p database
  if [ ! -f database/database.sqlite ]; then
    echo "==> Creating SQLite database file"
    touch database/database.sqlite
  fi
fi

echo "==> Running database migrations"
php artisan migrate --force

echo "==> Creating storage symlink"
php artisan storage:link || true

echo "==> Building frontend assets"
npm run build

echo ""
echo "Setup complete! Start the app with:"
echo "  php artisan serve"
echo "  npm run dev   (in a separate terminal, for hot reload)"
