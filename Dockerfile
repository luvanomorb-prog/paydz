FROM dunglas/frankenphp:latest-php8.3

# 1. تثبيت الحزم وإضافات قاعدة البيانات المطلوب لـ Laravel
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

WORKDIR /app

# 2. نسخ الملفات وتثبيت الاعتماديات (Composer مثبت مسبقاً في الصورة الرسمية)
COPY . .

RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# 3. تعديل الصلاحيات للمجلدات
RUN chmod -R 777 storage bootstrap/cache

# 4. إعدادات FrankenPHP الخاصة بالتوجيه والمنافذ
ENV SERVER_NAME=":8080"
EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp php-cli -S 0.0.0.0:${PORT:-8080} -t public/"]
