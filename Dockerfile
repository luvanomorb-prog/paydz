FROM php:8.4-cli

# تثبيت الحزم وإضافات PHP
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

# نسخ كافة ملفات المشروع
COPY . .

# تثبيت حزم PHP و Node
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# إعطاء الصلاحيات المباشرة لملفات الـ Storage والـ Cache
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8080

# أمر التشغيل الذي يتكفل بالـ Routing وتوجيه كافة الطلبات إلى public/index.php
CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php -S 0.0.0.0:${PORT:-8080} router.php"]
