@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Daftar Jenis Hewan</h1>
    <a href="{{ route('admin.hewan.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Hewan</a>
    
    <!-- Tombol Tambah Jenis Hewan -->
    <a href="{{ route('admin.hewan.create-jenis') }}" class="btn btn-primary mb-3">Tambah Jenis Hewan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Hewan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jenisHewan as $index => $jenis)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jenis->nama_jenis }}</td>
                <td>
                    <a href="{{ route('admin.hewan.edit-jenis', $jenis->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.hewan.delete-jenis', $jenis->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jenis hewan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
