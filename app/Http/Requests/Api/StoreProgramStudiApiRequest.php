<?php
// [P11] API Sanctum, JSON Resource, otorisasi token atau validasi.
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
class StoreProgramStudiApiRequest extends FormRequest {
 public function authorize(): bool { $u=$this->user(); return $u && $u->isAdmin() && $u->tokenCan('prodi:write'); }
 public function rules():array { return ['kode'=>['required','string','max:20','unique:program_studis,kode'],'nama'=>['required','string','max:120']]; }
}
