# [P01-P12] Jalankan dari PowerShell dalam folder laravel-si (bukan production).
$ErrorActionPreference = 'Stop'
Set-Location (Split-Path $PSScriptRoot -Parent)
php -v
composer install
if (!(Test-Path .env)) { Copy-Item .env.example .env }
if (!(Test-Path database/database.sqlite)) { New-Item -ItemType File database/database.sqlite | Out-Null }
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan storage:link
php artisan route:list
Write-Host 'Selesai. Jalankan php artisan serve'
