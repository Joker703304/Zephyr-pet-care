@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resep Obat</h1>
    <a href="{{ route('apoteker.resep_obat.create') }}" class="btn btn-primary mb-3">Tambah Resep Obat</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Resep</th>
                <th>Konsultasi</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep_obat as $resep)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $resep->konsultasi->keluhan }}</td>
                <td>{{ $resep->obat->nama_obat }}</td>
                <td>{{ $resep->jumlah }}</td>
                <td>{{ $resep->keterangan }}</td>
                <td>
                    <a href="{{ route('apoteker.resep_obat.edit', $resep->id_resep) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('apoteker.resep_obat.destroy', $resep->id_resep) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
