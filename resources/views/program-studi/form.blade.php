{-- [P03] Blade UI dan Bootstrap untuk aplikasi akademik. --}
@extends('layouts.app')
@section('title',$isEdit?'Edit Program Studi':'Tambah Program Studi')
@section('content')<h1>{{ $isEdit?'Edit':'Tambah' }} Program Studi</h1>
<div class="card"><div class="card-body"><form method="post" action="{{ $isEdit?route('program-studi.update',$prodi):route('program-studi.store') }}">@csrf @if($isEdit)@method('PUT')@endif
@foreach(['kode'=>'Kode','nama'=>'Nama'] as $field=>$label)<div class="mb-3"><label for="{{ $field }}" class="form-label">{{ $label }}</label><input id="{{ $field }}" name="{{ $field }}" value="{{ old($field,$prodi->$field) }}" class="form-control @error($field)is-invalid @enderror">@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>@endforeach
<button class="btn btn-primary">Simpan</button><a class="btn btn-outline-secondary" href="{{ route('program-studi.index') }}">Batal</a></form></div></div>
@endsection
