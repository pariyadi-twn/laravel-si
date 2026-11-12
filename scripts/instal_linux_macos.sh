#!/usr/bin/env bash
set -euo pipefail
# [P01] Instalasi ulang untuk lingkungan development baru (bukan produksi).
cd "$(dirname "$0")/.."
php -v
composer install
if [ ! -f .env ]; then cp .env.example .env; fi
if [ ! -f database/database.sqlite ]; then touch database/database.sqlite; fi
php artisan key:generate
# [P04] Jalankan migration NON-destruktif. Peringatan: seeder membuat akun dummy.
php artisan migrate --seed
# [P03] Build asset Bootstrap melalui Vite.
npm install
npm run build
# [P10] Symlink hanya untuk foto publik. PDF tetap di disk private.
php artisan storage:link || true
php artisan route:list
printf '\nSelesai. Jalankan: php artisan serve\n'
