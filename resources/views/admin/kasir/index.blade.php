@extends('layouts.main')

@section('content')
<div class="container">
    <h1>List of kasir</h1>
    <a href="{{ route('admin.kasir.create') }}" class="btn btn-primary mb-3">Add kasir</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kasir as $kasir)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kasir->user->name }}</td>
                    <td>{{ $kasir->user->email }}</td>
                    <td>{{ $$kasir->no_telepon }}</td>
                    <td>{{ ucfirst($kasir->jenkel) }}</td>
                    <td>{{ $kasir->alamat }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                        <form action="{{ route('admin.dokter.destroy',$kasir->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
