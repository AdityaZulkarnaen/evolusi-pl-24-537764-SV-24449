#!/usr/bin/env bash
# Deploy aplikasi ke server. Dijalankan di server, bukan di laptop.
set -e # berhenti begitu ada perintah yang gagal

cd "${APP_DIR:-/var/www/evolusi-pl}"

# 1 - Tampilkan halaman pemeliharaan selama pembaruan
php artisan down --retry=60

# 2 - Ambil kode terbaru dari main
git pull origin main

# 3 - Pasang dependensi tanpa paket pengembangan
composer install --no-dev --optimize-autoloader --no-interaction

# 4 - Perbarui skema basis data tanpa konfirmasi
php artisan migrate --force

# 5 - Bangun ulang cache dengan kode dan konfigurasi baru
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6 - Muat ulang pekerja antrean yang masih memegang kode lama
php artisan queue:restart

# 7 - Buka kembali aplikasi
php artisan up
