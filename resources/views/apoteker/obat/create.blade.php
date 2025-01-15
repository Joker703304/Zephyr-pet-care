@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Obat Baru</h1>
    
    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Drug Form -->
    <form action="{{ route('apoteker.obat.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nama_obat">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="jenis_obat">Jenis Obat</label>
            <input type="text" name="jenis_obat" id="jenis_obat" class="form-control" value="{{ old('jenis_obat') }}">
        </div>

        <div class="form-group mb-3">
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="harga">Harga</label>
            <input type="text" name="harga" id="harga" class="form-control"  value="{{ old('harga') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('apoteker.obat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Drug</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('apoteker.obat.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Enter drug name" value="{{ old('nama_obat') }}" required>
                </div>
        
                <div class="form-group mb-3">
                    <label for="jenis_obat">Jenis Obat</label>
                    <input type="text" name="jenis_obat" id="jenis_obat" class="form-control" placeholder="Enter drug type (optional)" value="{{ old('jenis_obat') }}">
                </div>
        
                <div class="form-group mb-3">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" placeholder="Enter stock quantity" value="{{ old('stok') }}" required>
                </div>
        
                <div class="form-group mb-3">
                    <label for="harga">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Enter price" value="{{ old('harga') }}" required>
                </div>
        
                <button type="submit" class="btn btn-primary">Save Drug</button>
                <a href="{{ route('apoteker.obat.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div> --}}
@endsection