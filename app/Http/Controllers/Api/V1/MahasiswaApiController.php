<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMahasiswaApiRequest;
use App\Http\Requests\Api\UpdateMahasiswaApiRequest;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class MahasiswaApiController extends Controller {
 private function canRead(Request $r):void { abort_unless(in_array($r->user()->role,['admin','staff'],true) && $r->user()->tokenCan('mahasiswa:read'),403); }
 private function canWrite(Request $r):void { abort_unless($r->user()->isAdmin() && $r->user()->tokenCan('mahasiswa:write'),403); }
 public function index(Request $r):AnonymousResourceCollection {
  $this->canRead($r);
  // [P11] API Resource + Eager Loading [P06] + pagination [P05].
  return MahasiswaResource::collection(Mahasiswa::with(['programStudi','mataKuliahs'])->orderBy('nama')->paginate(10));
 }
 public function show(Request $r,Mahasiswa $mahasiswa):MahasiswaResource {
  $this->canRead($r);return new MahasiswaResource($mahasiswa->load(['programStudi','mataKuliahs']));
 }
 public function store(StoreMahasiswaApiRequest $r):JsonResponse {
  $m=Mahasiswa::create($r->validated());
  return (new MahasiswaResource($m->load('programStudi')))->response()->setStatusCode(201);
 }
 public function update(UpdateMahasiswaApiRequest $r,Mahasiswa $mahasiswa):MahasiswaResource {
  $mahasiswa->update($r->validated());return new MahasiswaResource($mahasiswa->fresh()->load('programStudi'));
 }
 public function destroy(Request $r,Mahasiswa $mahasiswa):Response|JsonResponse {
  $this->canWrite($r);
  // [P10-P11] Hindari file privat yatim: untuk API contoh, larang hapus jika ada berkas.
  if($mahasiswa->dokumens()->exists() || $mahasiswa->foto_path) return response()->json(['message'=>'Hapus berkas mahasiswa dahulu.'],409);
  $mahasiswa->delete();return response()->noContent();
 }
}
