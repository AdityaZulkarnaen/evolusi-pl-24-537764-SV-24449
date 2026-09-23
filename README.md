# Ruang Rumah

Aplikasi web e-commerce sederhana untuk perabot rumah, dibangun dengan Laravel 13,
Blade, dan Tailwind CSS 4.

Fitur yang sudah ada:

- Halaman beranda: hero, filter kategori, dan katalog 8 produk (data contoh di controller).
- Autentikasi: daftar, masuk, keluar, dan halaman akun.
- Pengujian otomatis (PHPUnit) dan pipeline CI GitHub Actions.

## Kebutuhan sistem

| Kebutuhan | Versi |
| --- | --- |
| PHP | 8.3 atau lebih baru |
| Composer | 2.x |
| Node.js | 20 atau lebih baru |
| Basis data | SQLite (bawaan) atau MySQL 8 |

Ekstensi PHP yang dipakai: `mbstring`, `pdo_sqlite` (atau `pdo_mysql`), `intl`.

> **Pengguna Laragon/XAMPP di Windows.** Perintah `php` sering menunjuk ke PHP bawaan
> XAMPP yang masih 8.2 sehingga muncul galat `Composer detected issues in your platform`.
> Pakai terminal bawaan Laragon, atau tambahkan folder PHP 8.3 Laragon ke depan `PATH`:
>
> ```powershell
> $env:Path = "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64;$env:Path"
> php -v   # pastikan 8.3.x
> ```

## Instalasi

```bash
git clone https://github.com/AdityaZulkarnaen/evolusi-pl-24-537764-SV-24449.git
cd evolusi-pl-24-537764-SV-24449

composer install
cp .env.example .env        # Windows PowerShell: copy .env.example .env
php artisan key:generate
```

### Menyiapkan basis data

**SQLite (paling cepat, tanpa server basis data).** Pastikan `.env` berisi:

```
DB_CONNECTION=sqlite
```

Lalu buat berkasnya dan jalankan migrasi:

```bash
touch database/database.sqlite   # Windows PowerShell: New-Item database/database.sqlite
php artisan migrate
```

**MySQL.** Buat basis data kosong lebih dulu, lalu isi `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ruang_rumah
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
```

### Menyiapkan aset frontend

```bash
npm install
npm run build     # sekali jalan, hasilnya dipakai server biasa
```

Saat mengembangkan tampilan, pakai mode pantau supaya perubahan Blade dan CSS langsung
terlihat:

```bash
npm run dev
```

### Menjalankan aplikasi

```bash
php artisan serve
```

Buka http://127.0.0.1:8000.

## Perintah harian

| Perintah | Kegunaan |
| --- | --- |
| `php artisan serve` | Menjalankan server pengembangan |
| `npm run dev` | Memantau perubahan aset frontend |
| `npm run build` | Membangun aset untuk produksi |
| `php artisan test` | Menjalankan seluruh pengujian |
| `php artisan test --filter=AutentikasiTest` | Menjalankan satu berkas pengujian |
| `vendor/bin/pint` | Merapikan gaya penulisan kode PHP |
| `vendor/bin/pint --test` | Memeriksa gaya penulisan tanpa mengubah berkas |
| `php artisan migrate:fresh` | Membangun ulang basis data dari nol |

Aset hasil `npm run build` tidak ikut di-commit, jadi pengujian sengaja mematikan Vite
lewat `withoutVite()` di `tests/TestCase.php`.

## Struktur berkas utama

```
app/Http/Controllers/
    BerandaController.php        katalog produk halaman depan
    AkunController.php           halaman akun pengguna
    Auth/PendaftaranController.php
    Auth/SesiController.php      masuk dan keluar
resources/views/
    layouts/app.blade.php        kerangka halaman
    partials/                    header dan footer
    components/                  komponen Blade yang dipakai berulang
    beranda.blade.php
    akun.blade.php
    auth/                        halaman masuk dan daftar
routes/web.php                   seluruh rute aplikasi
tests/Feature/                   pengujian halaman dan autentikasi
.github/workflows/pipeline.yml   pipeline build → test → staging → production
```

## Alur kerja Git

### Struktur branch

| Branch | Peran |
| --- | --- |
| `main` | Versi stabil. Hanya menerima gabungan dari `dev`. |
| `dev` | Branch integrasi. Semua fitur bermuara ke sini. |
| `feat/...`, `fix/...` | Branch kerja untuk satu fitur atau satu perbaikan. |

Repositori ini punya dua remote:

| Remote | Alamat |
| --- | --- |
| `origin` | Repositori pribadi (`AdityaZulkarnaen/...`) |
| `org` | Repositori organisasi (`KEPL2026/...`) |

Periksa dengan `git remote -v`, dan sebutkan remote secara eksplisit saat push,
misalnya `git push origin dev`.

### Siklus mengerjakan satu tugas

```bash
# 1. Mulai dari dev yang terbaru
git checkout dev
git pull origin dev

# 2. Buat branch kerja
git checkout -b feat/keranjang-belanja

# 3. Kerjakan, lalu periksa sebelum commit
vendor/bin/pint
php artisan test

# 4. Commit perubahan
git add .
git commit -m "feat: tambah keranjang belanja"

# 5. Dorong ke remote
git push -u origin feat/keranjang-belanja
```

Setelah itu buka Pull Request dari `feat/keranjang-belanja` ke `dev` di GitHub,
tunggu seluruh job CI hijau, baru minta review dan gabungkan. Menjelang rilis,
`dev` digabungkan ke `main` lewat Pull Request tersendiri.

### Penamaan commit

Memakai format [Conventional Commits](https://www.conventionalcommits.org/):
`<jenis>: <ringkasan singkat dengan huruf kecil>`.

| Jenis | Dipakai untuk |
| --- | --- |
| `feat` | Fitur baru |
| `fix` | Perbaikan bug |
| `refactor` | Perubahan struktur kode tanpa mengubah perilaku |
| `test` | Menambah atau memperbaiki pengujian |
| `docs` | Perubahan dokumentasi |
| `chore` | Perkakas, konfigurasi, dependensi |
| `ci` | Perubahan pipeline CI |

Contoh: `feat: tambah halaman detail produk`, `fix: perbaiki validasi email ganda`.

### Menyelaraskan branch dengan dev

Kalau `dev` sudah maju sementara branch kerja belum selesai:

```bash
git checkout dev
git pull origin dev
git checkout feat/keranjang-belanja
git merge dev          # selesaikan konflik bila ada, lalu commit
```

### Aturan yang dipegang

- Jangan commit langsung ke `main`.
- Satu branch untuk satu tujuan; jangan campur fitur dan perbaikan dalam satu branch.
- Jalankan `vendor/bin/pint` dan `php artisan test` sebelum push agar CI tidak merah.
- Jangan pernah commit `.env`, `vendor/`, `node_modules/`, atau `public/build/`
  semuanya sudah tercantum di `.gitignore`.

## Integrasi berkelanjutan

`.github/workflows/pipeline.yml` berjalan pada setiap push dan Pull Request, dan dapat
pula dijalankan manual dari tab Actions. Isinya empat job yang berjalan berurutan lewat
`needs:`; jika satu job gagal, job setelahnya tidak dijalankan.

| Job | Isi |
| --- | --- |
| `build` | `composer install`, `vendor/bin/pint --test`, `npm ci`, `npm run build`, lalu mengunggah hasil build sebagai artifact |
| `test` | Memakai `vendor/` dan hasil build dari job `build`, menyiapkan `.env`, lalu `php artisan test` |
| `staging` | Simulasi deploy ke staging (masih `echo`) |
| `production` | Simulasi deploy ke production (masih `echo`) |

Pull Request baru boleh digabungkan setelah `build` dan `test` hijau.
