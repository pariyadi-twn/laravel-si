{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title',$isEdit?'Edit Mata Kuliah':'Tambah Mata Kuliah')
@section('content')<h1>{{ $isEdit?'Edit':'Tambah' }} Mata Kuliah</h1><div class="card"><div class="card-body"><form method="post" action="{{ $isEdit?route('mata-kuliah.update',$mataKuliah):route('mata-kuliah.store') }}">@csrf @if($isEdit)@method('PUT')@endif
@foreach(['kode'=>'Kode','nama'=>'Nama','sks'=>'Jumlah SKS'] as $field=>$label)<div class="mb-3"><label class="form-label" for="{{ $field }}">{{ $label }}</label><input id="{{ $field }}" name="{{ $field }}" value="{{ old($field,$mataKuliah->$field) }}" class="form-control @error($field)is-invalid @enderror">@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>@endforeach
<button class="btn btn-primary">Simpan</button><a class="btn btn-outline-secondary" href="{{ route('mata-kuliah.index') }}">Batal</a></form></div></div>@endsection
