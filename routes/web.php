<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaFileController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ExternalPostController;
use Illuminate\Support\Facades\Route;
// [P02] Method GET / mengembalikan redirect berbeda sesuai status login.
Route::get('/',fn()=>redirect()->route(auth()->check()?'dashboard':'login'));
Route::middleware('guest')->group(function():void {
 // [P09] Authentication session. throttle mengurangi percobaan login berulang.
 Route::get('/login',[AuthController::class,'loginForm'])->name('login');
 Route::post('/login',[AuthController::class,'login'])->middleware('throttle:5,1')->name('login.attempt');
 Route::get('/register',[AuthController::class,'registerForm'])->name('register');
 Route::post('/register',[AuthController::class,'register'])->middleware('throttle:5,1')->name('register.store');
 Route::get('/forgot-password',[PasswordResetController::class,'forgotForm'])->name('password.request');
 Route::post('/forgot-password',[PasswordResetController::class,'sendLink'])->middleware('throttle:5,1')->name('password.email');
 Route::get('/reset-password/{token}',[PasswordResetController::class,'resetForm'])->name('password.reset');
 Route::post('/reset-password',[PasswordResetController::class,'reset'])->name('password.update');
});
Route::middleware('auth')->group(function():void {
 // [P09] Semua halaman akademik terlindungi auth; Policy membatasi create/edit/delete.
 Route::post('/logout',[AuthController::class,'logout'])->name('logout');
 Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
 // [P09] Contoh langsung middleware alias role:admin (bukan hanya Blade @can).
 Route::get('/admin-only',fn()=>view('admin.index'))->middleware('role:admin')->name('admin.index');
 // [P02] Resource route + route model binding: {mahasiswa}, {programStudi}, {mataKuliah}.
 Route::resource('/mahasiswa',MahasiswaController::class);
 Route::resource('/program-studi',ProgramStudiController::class)->parameters(['program-studi'=>'programStudi']);
 Route::resource('/mata-kuliah',MataKuliahController::class)->parameters(['mata-kuliah'=>'mataKuliah']);
 // [P10] File upload & download. Semua POST/DELETE wajib @csrf dari Blade.
 Route::post('/mahasiswa/{mahasiswa}/foto',[MahasiswaFileController::class,'storeFoto'])->name('mahasiswa.foto.store');
 Route::delete('/mahasiswa/{mahasiswa}/foto',[MahasiswaFileController::class,'destroyFoto'])->name('mahasiswa.foto.destroy');
 Route::post('/mahasiswa/{mahasiswa}/dokumen',[MahasiswaFileController::class,'storeDokumen'])->name('mahasiswa.dokumen.store');
 Route::get('/mahasiswa/{mahasiswa}/dokumen/{dokumen}/download',[MahasiswaFileController::class,'downloadDokumen'])->name('mahasiswa.dokumen.download');
 Route::delete('/mahasiswa/{mahasiswa}/dokumen/{dokumen}',[MahasiswaFileController::class,'destroyDokumen'])->name('mahasiswa.dokumen.destroy');
 // [P12] Menampilkan artikel referensi JSONPlaceholder dengan HTTP Client.
 Route::get('/referensi-posts',[ExternalPostController::class,'index'])->name('external-posts.index');
 Route::get('/referensi-posts/{id}',[ExternalPostController::class,'show'])->whereNumber('id')->name('external-posts.show');
});
