FROM php:8.4-apache

# السماح لـ Composer بالعمل بحساب Root بدون تحذيرات
ENV COMPOSER_ALLOW_SUPERUSER=1

# 1. تفعيل موديل mod_rewrite الخاص بالـ Routing في Apache
RUN a2enmod rewrite

# 2. تثبيت الحزم وإضافات PHP الخاصة بـ Postgres والملفات
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

# 3. تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 4. نسخ ملفات المشروع
COPY . .

# 5. توجيه Apache لمجلد public بدلاً من جذر المشروع
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. ربط منفذ Apache بمنفذ Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# 7. تثبيت الحزم وبناء ملفات Vite
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
RUN npm install
RUN npm run build

# 8. ضبط الملكية والصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && php artisan storage:link || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && apache2-foreground"]
