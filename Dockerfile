# ==========================================
# Tahap 1: Membangun (Build Stage)
# ==========================================
FROM php:8.3.16-cli-alpine AS builder

# Pasang dependensi untuk kompilasi ekstensi PHP dan Composer
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    sqlite-dev \
    libxml2-dev

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_sqlite zip mbstring bcmath gd

# Kunci versi Composer tertentu (bukan latest)
COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# 1) Salin definisi dependensi dan pasang dependensi produksi
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# 2) Salin seluruh kode aplikasi
COPY . .

# Hapus file cache lokal host jika ada dan generate autoload teroptimasi
RUN rm -rf bootstrap/cache/*.php \
    && composer dump-autoload --optimize --no-dev --no-scripts


# ==========================================
# Tahap 2: Menjalankan (Runtime Stage)
# ==========================================
FROM php:8.3.16-cli-alpine

# Pasang ekstensi PHP untuk runtime dan bersihkan compiler dev
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libzip-dev \
        libpng-dev \
        oniguruma-dev \
        sqlite-dev \
    && docker-php-ext-install pdo_sqlite zip mbstring bcmath gd \
    && apk del .build-deps \
    && apk add --no-cache \
        libzip \
        libpng \
        oniguruma \
        sqlite-libs \
        curl

# Buat user non-root 'appuser'
RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -G appgroup -s /bin/sh -D appuser

WORKDIR /var/www/html

# Salin aplikasi dan vendor langsung dengan ownership appuser
COPY --chown=appuser:appgroup --from=builder /app /var/www/html

# Siapkan folder runtime Laravel, env, key, dan permission
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs \
             bootstrap/cache \
             database && \
    rm -rf bootstrap/cache/*.php && \
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan package:discover --ansi && \
    php artisan key:generate --force --no-interaction && \
    touch database/database.sqlite && \
    chown -R appuser:appgroup storage bootstrap/cache database && \
    chmod -R 775 storage bootstrap/cache database

# Gunakan user non-root
USER appuser

# Ekspos port aplikasi
EXPOSE 8000

# Healthcheck ke endpoint /up bawaan Laravel
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD curl -f http://127.0.0.1:8000/up || exit 1

# Jalankan server aplikasi
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]