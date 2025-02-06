@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Daftar Hewan</h1>
    <a href="{{ route('admin.hewan.show-jenis') }}" class="btn btn-primary mb-3">Lihat Jenis Hewan</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pemilik</th>
                <th>Nama Hewan</th>
                <th>Jenis</th>
                <th>Jenis Kelamin</th>
                <th>Umur (Bulan)</th>
                <th>Berat (Gram)</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hewan as $item)
            <tr>
                <td>{{ $item->pemilik->nama ?? '-' }}</td>
                <td>{{ $item->nama_hewan }}</td>
                <td>{{ $item->jenis->nama_jenis ?? 'Jenis tidak ditemukan' }}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection