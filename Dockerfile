# Stage base solo PHP con pdo_pgsql (dev)
FROM laravelsail/php84-composer:latest AS php_base
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html

# Stage frontend (build assets con Vite)
FROM node:20-alpine AS frontend_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage backend (Laravel optimizado)
FROM php_base AS backend_build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts
COPY . .
RUN composer run-script post-autoload-dump
# Copiar assets compilados
COPY --from=frontend_build /app/public/build ./public/build

# Stage final para producción
FROM php_base AS runtime
COPY --from=backend_build /var/www/html /var/www/html
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
