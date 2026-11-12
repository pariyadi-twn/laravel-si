@props(['mahasiswa'])
{{-- [P03] Anonymous Blade Component reusable; [P06] menampilkan relasi. --}}
<div class="card mb-3"><div class="card-body"><h5><a href="{{ route('mahasiswa.show',$mahasiswa) }}">{{ $mahasiswa->nama }}</a></h5>
<p class="text-secondary mb-1">{{ $mahasiswa->nim }} · {{ $mahasiswa->programStudi?->nama }}</p>
@foreach($mahasiswa->mataKuliahs as $mk)<span class="badge text-bg-primary me-1">{{ $mk->kode }}</span>@endforeach
</div></div>
