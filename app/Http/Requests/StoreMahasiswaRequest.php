<?php
namespace App\Http\Requests;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreMahasiswaRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('create',Mahasiswa::class) ?? false; }
 public function rules(): array {
  // [P07] Validasi server, berbeda dengan HTML required yang mudah dilewati.
  return [
   'nim'=>['required','string','max:20','unique:mahasiswas,nim'],
   'nama'=>['required','string','max:120'],
   'email'=>['nullable','email','max:120','unique:mahasiswas,email'],
   'telepon'=>['nullable','string','max:25'],
   'program_studi_id'=>['required','integer',Rule::exists('program_studis','id')],
   'mata_kuliah_ids'=>['sometimes','array'],
   'mata_kuliah_ids.*'=>['integer','distinct',Rule::exists('mata_kuliahs','id')],
   'semester'=>['required',Rule::in(['Ganjil','Genap'])],
   'tahun_akademik'=>['required','regex:/^20[0-9]{2}\/20[0-9]{2}$/'],
  ];
 }
 public function messages(): array { return ['nim.required'=>'NIM wajib diisi.','nim.unique'=>'NIM sudah digunakan.','nama.required'=>'Nama mahasiswa wajib diisi.','program_studi_id.exists'=>'Program Studi tidak tersedia.']; }
}
