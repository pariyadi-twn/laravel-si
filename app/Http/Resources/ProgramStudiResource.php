<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ProgramStudiResource extends JsonResource {
 public function toArray(Request $request):array {
  // [P11] API Resource menjamin struktur JSON konsisten walaupun model berubah.
  return ['id'=>$this->id,'kode'=>$this->kode,'nama'=>$this->nama,
   'jumlah_mahasiswa'=>$this->whenCounted('mahasiswas')];
 }
}
