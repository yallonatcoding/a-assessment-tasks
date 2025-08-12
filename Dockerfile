# Stage base solo PHP con pdo_pgsql (para dev con Compose)
FROM laravelsail/php84-composer:latest AS php_base
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html

# Stage frontend (solo se ejecuta si llegas aquí)
FROM node:18-alpine AS frontend_build
WORKDIR /app
COPY frontend/package*.json ./frontend/
RUN npm install --prefix frontend
COPY frontend/. ./frontend/
RUN npm run build --prefix frontend

# Stage backend con Laravel optimizado (solo producción)
FROM php_base AS backend_build
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY . .
COPY --from=frontend_build /app/frontend/build ./public/frontend

# Stage final para producción
FROM php_base AS runtime
COPY --from=backend_build /var/www/html /var/www/html
CMD ["php-fpm"]
