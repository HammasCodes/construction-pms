# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# Stage 1 — build the front-end assets (Tailwind + Vite)
# ---------------------------------------------------------------------------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
# npm install (not ci): the lock file is generated on Windows, and npm ci is
# strict about cross-platform optional deps on musl Linux. install resolves
# fresh for this build platform and is reliable here.
RUN npm install --no-audit --no-fund
COPY . .
RUN npm run build

# ---------------------------------------------------------------------------
# Stage 2 — PHP runtime
# ---------------------------------------------------------------------------
FROM php:8.3-cli AS app

# System libraries + required PHP extensions (pdo_sqlite for the DB,
# mbstring + zip for Laravel/Composer).
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libonig-dev libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite mbstring zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Application source
COPY . .
# Compiled assets from the Node stage
COPY --from=assets /app/public/build ./public/build

# PHP dependencies (production) + writable dirs + empty SQLite DB
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && mkdir -p database storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

# Boot script: migrate, seed (idempotent), then serve on $PORT
COPY deploy/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

ENV PORT=8080
EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]
