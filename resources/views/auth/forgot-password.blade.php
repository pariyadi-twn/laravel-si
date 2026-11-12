{-- [P09] Antarmuka autentikasi dan reset password. --}
@extends('layouts.app')
@section('title','Lupa Password')
@section('content')<div class="row justify-content-center"><div class="col-md-6"><div class="card"><div class="card-body"><h1 class="h3">Lupa Password</h1><p>Masukkan email akun. Pada mode praktikum, tautan reset disimpan ke <code>storage/logs/laravel.log</code>.</p>
<form method="post" action="{{ route('password.email') }}">@csrf<label class="form-label" for="email">Email</label><input type="email" name="email" id="email" class="form-control mb-2" value="{{ old('email') }}">@error('email')<p class="text-danger">{{ $message }}</p>@enderror<button class="btn btn-primary">Kirim Link</button></form>
</div></div></div></div>@endsection
