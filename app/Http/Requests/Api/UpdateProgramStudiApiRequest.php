<?php
// [P11] API Sanctum, JSON Resource, otorisasi token atau validasi.
namespace App\Http\Requests\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProgramStudiApiRequest extends FormRequest {
 public function authorize(): bool { $u=$this->user();return $u && $u->isAdmin() && $u->tokenCan('prodi:write'); }
 public function rules():array { $id=$this->route('programStudi')->id;return ['kode'=>['required','string','max:20',Rule::unique('program_studis','kode')->ignore($id)],'nama'=>['required','string','max:120']]; }
}
