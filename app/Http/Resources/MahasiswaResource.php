<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class MahasiswaResource extends JsonResource {
 public function toArray(Request $request):array {
  // [P11] Metadata private document, foto asli, email user tidak diekspos dari sini.
  return ['id'=>$this->id,'nim'=>$this->nim,'nama'=>$this->nama,
   'email'=>$this->email,'telepon'=>$this->telepon,
   'program_studi'=>$this->whenLoaded('programStudi',fn()=>['id'=>$this->programStudi->id,'nama'=>$this->programStudi->nama,'kode'=>$this->programStudi->kode]),
   'mata_kuliahs'=>$this->whenLoaded('mataKuliahs',fn()=> $this->mataKuliahs->map(fn($m)=>['id'=>$m->id,'nama'=>$m->nama,'semester'=>$m->pivot->semester,'tahun_akademik'=>$m->pivot->tahun_akademik])),
  ];
 }
}
