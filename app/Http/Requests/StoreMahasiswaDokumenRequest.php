<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreMahasiswaDokumenRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('update',$this->route('mahasiswa')) ?? false; }
 public function rules(): array {
  // [P10] PDF maksimal 5MB dan kategori terkontrol; tidak menerima .php/.exe.
  return ['dokumen'=>['required','file','mimetypes:application/pdf','max:5120'], 'kategori'=>['required',Rule::in(['Surat','Sertifikat','Lainnya'])]];
 }
}
