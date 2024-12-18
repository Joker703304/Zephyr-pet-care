@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Create Layanan</h1>
        <form action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_layanan">Nama Layanan</label>
                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create</button>
        </form>
    </div>
@endsection
