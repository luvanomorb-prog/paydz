FROM dunglas/frankenphp:latest-php8.3

# تثبيت الحزم وإضافات PHP المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    nodejs \
    npm \
 && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    gd \
    zip \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# جلب Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# نسخ الملفات
COPY . .

# تثبيت حزم PHP و Node وبناء الـ Assets
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# إعطاء الصلاحيات المباشرة
RUN chmod -R 777 storage bootstrap/cache

ENV SERVER_NAME=":8080"
EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp php-server --root public/"]
