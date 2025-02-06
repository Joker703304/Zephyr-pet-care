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
            </tr>
        </thead>
        <tbody>
            @foreach($jenisHewan as $index => $jenis)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jenis->nama_jenis }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
