FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    gd \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-dev

RUN npm install && npm run build

RUN php artisan storage:link || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=$PORT
