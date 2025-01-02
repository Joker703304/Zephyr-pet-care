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
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep_obat as $id_konsultasi => $resepGroup)
            <tr>
                <td>{{ $id_konsultasi }}</td>
                <td>{{ $resepGroup->first()->konsultasi->keluhan }}</td>
                <td>
                    @foreach ($resepGroup as $resep)
                        <span>{{ $resep->obat->nama_obat }} ({{ $resep->jumlah }})</span><br>
                    @endforeach
                </td>
                <td>{{ $resepGroup->first()->keterangan }}</td>
                <td>
                    <a href="{{ route('apoteker.resep_obat.edit', $resepGroup->first()->id_resep) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('apoteker.resep_obat.destroy', $resepGroup->first()->id_resep) }}" method="POST" style="display:inline;">
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
