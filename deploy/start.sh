#!/bin/sh
# Container start-up: prepare the app, then serve it.
set -e

# Make sure the SQLite database file exists and is writable.
mkdir -p database
[ -f database/database.sqlite ] || touch database/database.sqlite

# Apply schema and seed demo data (seeder is idempotent — safe every boot).
php artisan migrate --force
php artisan db:seed --force || true

# Cache config/views for a faster, production-like response.
# (route:cache is skipped — the "/" redirect uses a closure.)
php artisan config:cache || true
php artisan view:cache || true

# Serve. Railway injects $PORT; default to 8080 locally.
exec php artisan serve --host 0.0.0.0 --port "${PORT:-8080}"
