@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Layanan List</h1>
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">Create Layanan</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanans as $layanan)
                    <tr>
                        <td>{{ $layanan->nama_layanan }}</td>
                        <td>{{ $layanan->deskripsi }}</td>
                        <td>{{ $layanan->harga }}</td>
                        <td>
                            <a href="{{ route('admin.layanan.edit', $layanan->id_layanan) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.layanan.destroy', $layanan->id_layanan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
