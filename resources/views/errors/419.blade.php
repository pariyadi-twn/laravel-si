@extends('layouts.app')
@section('title','Sesi Kedaluwarsa')
@section('content')
{-- [P07] Error page ramah pengguna: jangan tampilkan stack trace atau file rahasia. --}
<div class="text-center py-5"><h1 class="display-4">419</h1><h2>Sesi Kedaluwarsa</h2><p>Segarkan halaman dan coba lagi. Ini dapat terjadi jika token CSRF tidak sesuai.</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a></div>
@endsection
