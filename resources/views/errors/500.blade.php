@extends('layouts.app')
@section('title','Terjadi Kesalahan Server')
@section('content')
{-- [P07] Error page ramah pengguna: jangan tampilkan stack trace atau file rahasia. --}
<div class="text-center py-5"><h1 class="display-4">500</h1><h2>Terjadi Kesalahan Server</h2><p>Silakan hubungi pengelola jika masalah terus terjadi.</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a></div>
@endsection
