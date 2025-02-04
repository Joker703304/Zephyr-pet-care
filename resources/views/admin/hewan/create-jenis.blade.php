@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Tambah Jenis Hewan</h1>
    
    <a href="{{ route('admin.hewan.show-jenis') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Jenis Hewan</a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form untuk menambah jenis hewan -->
    <form action="{{ route('admin.hewan.store-jenis') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="jenis">Jenis Hewan</label>
            <input type="text" name="jenis" id="jenis" class="form-control" value="{{ old('jenis') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan Jenis Hewan</button>
    </form>
</div>
@endsection
