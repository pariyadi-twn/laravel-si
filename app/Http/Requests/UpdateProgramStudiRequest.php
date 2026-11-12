<?php
// [P07] Form Request validation pada operasi CRUD.
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProgramStudiRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('update',$this->route('programStudi')) ?? false; }
 public function rules(): array { $id=$this->route('programStudi')->getKey(); return ['kode'=>['required','string','max:20',Rule::unique('program_studis','kode')->ignore($id)],'nama'=>['required','string','max:120']]; }
}
