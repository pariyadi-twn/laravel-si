<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreMahasiswaFotoRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('update',$this->route('mahasiswa')) ?? false; }
 public function rules(): array {
  // [P10] Maksimum 2MB. Fileinfo memeriksa MIME; ekstensi asli bukan satu-satunya indikator.
  return ['foto'=>['required','file','mimes:jpg,jpeg,png,webp','max:2048']];
 }
}
