@extends('layouts.app')

@section('content')
<div class="container">
    
    <a href="{{ route('apoteker.obat.create') }}" class="btn btn-success mb-3">Tambah Obat</a>
    <a href="{{ route('apoteker.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Drugs Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Obat</th>
                <th>Nama Obat</th>
                <th>Jenis Obat</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $obat)
            <tr>
                <td>{{ $obat->id_obat }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->jenis_obat }}</td>
                <td>{{ $obat->stok }}</td>
                <td>{{ $obat->harga }}</td>
                <td>
                    <a href="{{ route('apoteker.obat.edit', $obat->id_obat) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('apoteker.obat.destroy', $obat->id_obat) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this drug?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- DataTales Example -->
    {{-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Drugs Management</h6>
        </div>
        <a href="{{ route('apoteker.obat.create') }}" class="btn btn-success mb-3">Add New Drug</a>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Obat</th>
                            <th>Nama Obat</th>
                            <th>Jenis Obat</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($obats as $obat)
                        <tr>
                            <td>{{ $obat->id_obat }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->jenis_obat }}</td>
                            <td>{{ $obat->stok }}</td>
                            <td>{{ $obat->harga }}</td>
                            <td>
                                <a href="{{ route('apoteker.obat.edit', $obat->id_obat) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('apoteker.obat.destroy', $obat->id_obat) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this drug?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

@endsection