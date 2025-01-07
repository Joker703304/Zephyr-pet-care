@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Hewan</h1>
    <a href="{{ route('pemilik-hewan.hewan.create') }}" class="btn btn-success mb-3">Tambah Hewan</a>
    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                {{-- <th>ID Hewan</th> --}}
                <th>Pemilik</th>
                <th>Nama Hewan</th>
                <th>Jenis</th>
                <th>Jenis Kelamin</th>
                <th>Umur (Bulan)</th>
                <th>Berat (Gram)</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hewan as $item)
            <tr>
                {{-- <td>{{ $loop->iteration }}</td> --}}
                <td>{{ $item->pemilik->nama ?? '-' }}</td>
                <td>{{ $item->nama_hewan }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->jenkel }}</td>
                <td>{{ $item->umur }}</td>
                <td>{{ $item->berat }}</td>
                <td>
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" width="50">
                    @else
                        Tidak ada
                    @endif
                </td>
                <td>
                    <a href="{{ route('pemilik-hewan.hewan.edit', $item->id_hewan) }}" class="btn btn-warning btn-sm">Edit</a>
                    {{-- <form action="{{ route('pemilik-hewan.hewan.destroy', $item->id_hewan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection