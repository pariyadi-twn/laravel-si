@extends('layouts.app')
@section('title','Akses Ditolak')
@section('content')
{-- [P07] Error page ramah pengguna: jangan tampilkan stack trace atau file rahasia. --}
<div class="text-center py-5"><h1 class="display-4">403</h1><h2>Akses Ditolak</h2><p>Anda tidak mempunyai izin untuk menjalankan tindakan ini.</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a></div>
@endsection
