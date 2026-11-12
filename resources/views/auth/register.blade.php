@extends('layouts.app')
@section('title','Daftar Akun')
@section('content')<div class="row justify-content-center"><div class="col-md-6"><div class="card"><div class="card-body p-4"><h1 class="h3">Daftar Akun Staff</h1><p class="text-secondary">[P09] Registrasi publik tidak dapat membuat akun admin.</p>
<form method="post" action="{{ route('register.store') }}">@csrf
@foreach(['name'=>'Nama','email'=>'Email','password'=>'Password','password_confirmation'=>'Ulangi Password'] as $field=>$label)
<div class="mb-3"><label class="form-label" for="{{ $field }}">{{ $label }}</label><input id="{{ $field }}" type="{{ str_contains($field,'password')?'password':($field==='email'?'email':'text') }}" class="form-control @error($field)is-invalid @enderror" name="{{ $field }}" value="{{ in_array($field,['name','email'])?old($field):'' }}" required>@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
@endforeach<button class="btn btn-primary">Daftar</button><a href="{{ route('login') }}" class="btn btn-outline-secondary">Login</a></form></div></div></div></div>@endsection
