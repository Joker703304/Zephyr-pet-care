@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Jenis Hewan</h1>
    <a href="{{ route('admin.hewan.show-jenis') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.hewan.update-jenis', $jenis->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Nama Jenis Hewan</label>
            <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="{{ old('nama_jenis', $jenis->nama_jenis) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
