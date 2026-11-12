<?php
// [P07] Form Request validation pada operasi CRUD.
namespace App\Http\Requests;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreProgramStudiRequest extends FormRequest {
 public function authorize(): bool { return $this->user()?->can('create',ProgramStudi::class) ?? false; }
 public function rules(): array { return ['kode'=>['required','string','max:20','unique:program_studis,kode'],'nama'=>['required','string','max:120']]; }
}
