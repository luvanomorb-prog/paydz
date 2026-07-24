FROM php:8.4-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

# 1. تثبيت الحزم والإضافات
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

# 2. حل مشكلة MPM وتفعيل mod_rewrite لـ Apache
RUN a2dismod mpm_event mpm_worker || true \
 && a2enmod mpm_prefork rewrite

# 3. تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 4. نسخ ملفات المشروع
COPY . .

# 5. ضبط مسار DocumentRoot ليكون public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. تثبيت الحزم وبناء الواجهة
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# 7. ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

# 8. أمر التشغيل مع ربط المنفذ الديناميكي
CMD ["sh", "-c", "sed -i \"s/80/${PORT:-8080}/g\" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf && php artisan migrate --force && php artisan storage:link || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && apache2-foreground"]
