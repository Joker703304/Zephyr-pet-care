@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Tambah Jenis Hewan</h1>
    <a href="{{ route('admin.hewan.show-jenis') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Jenis Hewan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.hewan.store-jenis') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_jenis">Nama Jenis Hewan</label>
            <input type="text" name="nama_jenis" id="nama_jenis" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection
