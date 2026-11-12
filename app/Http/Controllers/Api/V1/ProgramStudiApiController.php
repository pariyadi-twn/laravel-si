<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProgramStudiApiRequest;
use App\Http\Requests\Api\UpdateProgramStudiApiRequest;
use App\Http\Resources\ProgramStudiResource;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class ProgramStudiApiController extends Controller {
 private function canRead(Request $r):void { abort_unless(in_array($r->user()->role,['admin','staff'],true) && $r->user()->tokenCan('prodi:read'),403); }
 private function canWrite(Request $r):void { abort_unless($r->user()->isAdmin() && $r->user()->tokenCan('prodi:write'),403); }
 public function index(Request $r):AnonymousResourceCollection {
  $this->canRead($r); // [P11] Token ability DAN role diperiksa.
  return ProgramStudiResource::collection(ProgramStudi::withCount('mahasiswas')->orderBy('nama')->paginate(10));
 }
 public function show(Request $r,ProgramStudi $programStudi):ProgramStudiResource { $this->canRead($r);return new ProgramStudiResource($programStudi->loadCount('mahasiswas')); }
 public function store(StoreProgramStudiApiRequest $r):JsonResponse { $p=ProgramStudi::create($r->validated());return (new ProgramStudiResource($p))->response()->setStatusCode(201); }
 public function update(UpdateProgramStudiApiRequest $r,ProgramStudi $programStudi):ProgramStudiResource { $programStudi->update($r->validated());return new ProgramStudiResource($programStudi->fresh()); }
 public function destroy(Request $r,ProgramStudi $programStudi):Response|JsonResponse {
  $this->canWrite($r);
  // [P11] 409 Conflict jika relasi mahasiswa masih menggunakan Prodi.
  if($programStudi->mahasiswas()->exists()) return response()->json(['message'=>'Prodi masih digunakan mahasiswa.'],409);
  $programStudi->delete();return response()->noContent(); // [P11] 204 tanpa body.
 }
}
