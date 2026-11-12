<?php
// [P01] Contoh Artisan console route: php artisan list
use Illuminate\Support\Facades\Artisan;
Artisan::command('laravel-si:hello', function (): void {
    $this->comment('Halo mahasiswa! Project laravel-si P01–P12 siap dipelajari.');
})->purpose('Salam praktikum Laravel SI');
