<?php
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\MahasiswaApiController;
use App\Http\Controllers\Api\V1\ProgramStudiApiController;
use App\Http\Controllers\Api\V1\ExternalPostApiController;
use Illuminate\Support\Facades\Route;
// [P11] bootstrap/app.php menambahkan /api secara otomatis. Final URL /api/v1/...
Route::prefix('v1')->group(function():void {
 Route::post('login',[AuthApiController::class,'login'])->middleware('throttle:5,1');
 Route::middleware('auth:sanctum')->group(function():void {
  Route::get('me',[AuthApiController::class,'me']);
  Route::post('logout',[AuthApiController::class,'logout']);
  Route::apiResource('program-studi',ProgramStudiApiController::class)->parameters(['program-studi'=>'programStudi']);
  Route::apiResource('mahasiswa',MahasiswaApiController::class);
  // [P12] API internal membaca layanan eksternal via Laravel HTTP Client.
  Route::get('referensi-posts',[ExternalPostApiController::class,'index']);
  Route::get('referensi-posts/{id}',[ExternalPostApiController::class,'show'])->whereNumber('id');
 });
});
