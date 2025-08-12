# Stage base solo PHP con pdo_pgsql (dev)
FROM laravelsail/php84-composer:latest AS dev
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html

FROM php:8.4-fpm AS prod
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html

# Stage frontend (build assets con Vite)
FROM node:20-alpine AS frontend_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage backend (Laravel optimizado)
FROM prod AS backend_build
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts
COPY . .
RUN composer run-script post-autoload-dump

# Copiar assets compilados
COPY --from=frontend_build /app/public/build ./public/build

# Stage final para producción
FROM prod AS runtime
WORKDIR /var/www/html
COPY --from=backend_build /var/www/html /var/www/html

# Ejecutar migraciones y luego el servidor embebido (puedes cambiar a php-fpm si quieres)
CMD ["php-fpm", "-F"]
