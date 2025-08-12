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
    nginx \
    && docker-php-ext-install pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html

FROM node:20-alpine AS frontend_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

FROM prod AS backend_build
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts
COPY . .
RUN composer run-script post-autoload-dump
COPY --from=frontend_build /app/public/build ./public/build

FROM prod AS runtime
WORKDIR /var/www/html
COPY --from=backend_build /var/www/html /var/www/html

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
