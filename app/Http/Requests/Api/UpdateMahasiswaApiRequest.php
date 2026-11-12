<?php
// [P11] API Sanctum, JSON Resource, otorisasi token atau validasi.
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateMahasiswaApiRequest extends FormRequest {
 public function authorize(): bool { $u=$this->user();return $u && $u->isAdmin() && $u->tokenCan('mahasiswa:write'); }
 public function rules():array { $id=$this->route('mahasiswa')->id;return [
  'nim'=>['required','string','max:20',Rule::unique('mahasiswas','nim')->ignore($id)],
  'nama'=>['required','string','max:120'],
  'email'=>['nullable','email','max:120',Rule::unique('mahasiswas','email')->ignore($id)],
  'telepon'=>['nullable','string','max:25'],'program_studi_id'=>['required','integer',Rule::exists('program_studis','id')],
 ]; }
}
