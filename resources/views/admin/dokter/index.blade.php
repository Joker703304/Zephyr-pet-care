@extends('layouts.main')

@section('content')
<div class="container">
    <h1>List of Doctors</h1>
    <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary mb-3">Add Doctor</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Spesialis</th>
                <th>No Telepon</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dokters as $dokter)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dokter->user->name }}</td>
                    <td>{{ $dokter->user->email }}</td>
                    <td>{{ $dokter->spesialis }}</td>
                    <td>{{ $dokter->no_telepon }}</td>
                    <td>{{ ucfirst($dokter->jenkel) }}</td>
                    <td>{{ $dokter->alamat }}</td>
                    <td>
                        <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" style="display:inline-block;">
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
