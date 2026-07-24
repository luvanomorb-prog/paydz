FROM php:8.4-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

# 1. تثبيت Nginx والحزم والإضافات
RUN apt-get update && apt-get install -y \
    nginx \
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

# 2. تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3. نسخ ملفات المشروع
COPY . .

# 4. تثبيت الحزم وبناء الواجهة
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# 5. ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6. إعداد Nginx المخصص لـ Laravel
RUN echo 'server {\n\
    listen 8080;\n\
    server_name _;\n\
    root /var/www/html/public;\n\
    index index.php;\n\
    charset utf-8;\n\
\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
\n\
    location ~ /\.ht {\n\
        deny all;\n\
    }\n\
}' > /etc/nginx/sites-available/default

EXPOSE 8080

# 7. تشغيل PHP-FPM و Nginx معاً مع إعدادات Laravel
CMD ["sh", "-c", "sed -i \"s/8080/${PORT:-8080}/g\" /etc/nginx/sites-available/default && php-fpm -D && php artisan migrate --force && php artisan storage:link || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && nginx -g 'daemon off;'"]
