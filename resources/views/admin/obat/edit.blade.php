@extends('layouts.main')

@section('content')
<div class="container">
    
    
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

    <!-- Edit Drug Form -->
    {{-- <form action="{{ route('admin.obat.update', $obat->id_obat) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="nama_obat">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Enter drug name" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="jenis_obat">Jenis Obat</label>
            <input type="text" name="jenis_obat" id="jenis_obat" class="form-control" placeholder="Enter drug type (optional)" value="{{ old('jenis_obat', $obat->jenis_obat) }}">
        </div>

        <div class="form-group mb-3">
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" placeholder="Enter stock quantity" value="{{ old('stok', $obat->stok) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="harga">Harga</label>
            <input type="text" name="harga" id="harga" class="form-control" placeholder="Enter price" value="{{ old('harga', $obat->harga) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Drug</button>
        <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Cancel</a>
    </form> --}}
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Drug</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.obat.update', $obat->id_obat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Enter drug name" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                </div>
        
                <div class="form-group mb-3">
                    <label for="jenis_obat">Jenis Obat</label>
                    <input type="text" name="jenis_obat" id="jenis_obat" class="form-control" placeholder="Enter drug type (optional)" value="{{ old('jenis_obat', $obat->jenis_obat) }}">
                </div>
        
                <div class="form-group mb-3">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" placeholder="Enter stock quantity" value="{{ old('stok', $obat->stok) }}" required>
                </div>
        
                <div class="form-group mb-3">
                    <label for="harga">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Enter price" value="{{ old('harga', $obat->harga) }}" required>
                </div>
        
                <button type="submit" class="btn btn-primary">Update Drug</button>
                <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
