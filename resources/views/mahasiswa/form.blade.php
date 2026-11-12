@extends('layouts.app')
@section('title',$isEdit?'Edit Mahasiswa':'Tambah Mahasiswa')
@section('content')
<h1 class="page-heading">{{ $isEdit?'Edit':'Tambah' }} Mahasiswa</h1>
<div class="card"><div class="card-body">
<form method="post" action="{{ $isEdit?route('mahasiswa.update',$mahasiswa):route('mahasiswa.store') }}">
 @csrf {{-- [P07] Token Cross-Site Request Forgery. --}}
 @if($isEdit)@method('PUT')@endif
 @foreach(['nim'=>'NIM','nama'=>'Nama','email'=>'Email','telepon'=>'Telepon'] as $field=>$label)
 <div class="mb-3"><label class="form-label" for="{{ $field }}">{{ $label }}</label>
 <input type="{{ $field==='email'?'email':'text' }}" id="{{ $field }}" name="{{ $field }}" value="{{ old($field,$mahasiswa->$field) }}" class="form-control @error($field) is-invalid @enderror">
 @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
 @endforeach
 <div class="mb-3"><label class="form-label" for="prodi">Program Studi</label><select id="prodi" name="program_studi_id" class="form-select @error('program_studi_id') is-invalid @enderror"><option value="">Pilih prodi</option>
 @foreach($prodis as $p)<option value="{{ $p->id }}" @selected(old('program_studi_id',$mahasiswa->program_studi_id)==$p->id)>{{ $p->nama }}</option>@endforeach</select>
 @error('program_studi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
 {{-- [P06] Pivots: multi-select many-to-many dan dua atribut pivot. --}}
 @php($selected=old('mata_kuliah_ids',$isEdit?$mahasiswa->mataKuliahs->pluck('id')->all():[]))
 <div class="mb-3"><label class="form-label" for="mk">Mata Kuliah (tahan Ctrl untuk memilih beberapa)</label><select id="mk" name="mata_kuliah_ids[]" multiple size="5" class="form-select">
 @foreach($mataKuliahs as $mk)<option value="{{ $mk->id }}" @selected(in_array($mk->id,array_map('intval',(array)$selected)))>{{ $mk->kode }} — {{ $mk->nama }}</option>@endforeach</select>
 @error('mata_kuliah_ids.*')<div class="text-danger small">{{ $message }}</div>@enderror</div>
 <div class="row"><div class="col-md-6 mb-3"><label class="form-label" for="semester">Semester</label><select name="semester" id="semester" class="form-select"><option @selected(old('semester','Ganjil')==='Ganjil')>Ganjil</option><option @selected(old('semester')==='Genap')>Genap</option></select></div>
 <div class="col-md-6 mb-3"><label class="form-label" for="tahun_akademik">Tahun Akademik</label><input name="tahun_akademik" id="tahun_akademik" class="form-control" value="{{ old('tahun_akademik','2026/2027') }}"></div></div>
 <button class="btn btn-primary">Simpan</button><a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">Batal</a>
</form></div></div>
@endsection
