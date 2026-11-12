<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateMahasiswaRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('update',$this->route('mahasiswa')) ?? false; }
 public function rules(): array {
  $id=$this->route('mahasiswa')->getKey();
  // [P07] unique() harus ignore record saat UPDATE, bukan saat CREATE.
  return [
   'nim'=>['required','string','max:20',Rule::unique('mahasiswas','nim')->ignore($id)],
   'nama'=>['required','string','max:120'],
   'email'=>['nullable','email','max:120',Rule::unique('mahasiswas','email')->ignore($id)],
   'telepon'=>['nullable','string','max:25'],
   'program_studi_id'=>['required','integer',Rule::exists('program_studis','id')],
   'mata_kuliah_ids'=>['sometimes','array'],
   'mata_kuliah_ids.*'=>['integer','distinct',Rule::exists('mata_kuliahs','id')],
   'semester'=>['required',Rule::in(['Ganjil','Genap'])],
   'tahun_akademik'=>['required','regex:/^20[0-9]{2}\/20[0-9]{2}$/'],
  ];
 }
 public function messages(): array { return ['nim.required'=>'NIM wajib diisi.','nim.unique'=>'NIM sudah dipakai mahasiswa lain.','nama.required'=>'Nama wajib diisi.']; }
}
