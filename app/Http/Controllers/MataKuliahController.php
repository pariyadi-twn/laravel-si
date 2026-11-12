<?php
// [P05] Controller web untuk Eloquent CRUD.
namespace App\Http\Controllers;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class MataKuliahController extends Controller {
 public function index(): View { Gate::authorize('viewAny',MataKuliah::class); return view('mata-kuliah.index',['matakuliahs'=>MataKuliah::withCount('mahasiswas')->orderBy('nama')->paginate(10)]); }
 public function create(): View { Gate::authorize('create',MataKuliah::class); return view('mata-kuliah.form',['mataKuliah'=>new MataKuliah(),'isEdit'=>false]); }
 public function store(Request $request): RedirectResponse {
  Gate::authorize('create',MataKuliah::class);
  $data=$request->validate(['kode'=>['required','string','max:20','unique:mata_kuliahs,kode'],'nama'=>['required','string','max:120'],'sks'=>['required','integer','between:1,6']]);
  MataKuliah::create($data); return redirect()->route('mata-kuliah.index')->with('success','Mata kuliah ditambahkan.');
 }
 public function show(MataKuliah $mataKuliah): View { Gate::authorize('view',$mataKuliah); return view('mata-kuliah.show',['mataKuliah'=>$mataKuliah->load('mahasiswas')]); }
 public function edit(MataKuliah $mataKuliah): View { Gate::authorize('update',$mataKuliah); return view('mata-kuliah.form',compact('mataKuliah')+['isEdit'=>true]); }
 public function update(Request $request,MataKuliah $mataKuliah): RedirectResponse {
  Gate::authorize('update',$mataKuliah);
  $data=$request->validate(['kode'=>['required','string','max:20',Rule::unique('mata_kuliahs','kode')->ignore($mataKuliah->id)],'nama'=>['required','string','max:120'],'sks'=>['required','integer','between:1,6']]);
  $mataKuliah->update($data); return redirect()->route('mata-kuliah.index')->with('success','Mata kuliah diperbarui.');
 }
 public function destroy(MataKuliah $mataKuliah): RedirectResponse { Gate::authorize('delete',$mataKuliah); $mataKuliah->delete(); return redirect()->route('mata-kuliah.index')->with('success','Mata kuliah dihapus.'); }
}
