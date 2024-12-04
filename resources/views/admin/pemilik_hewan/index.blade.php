@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Owners Management</h1>
    <a href="{{ route('admin.pemilik_hewan.create') }}" class="btn btn-success mb-3">Add New Owner</a>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Owner Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $pemilik)
            <tr>
                <td>{{ $pemilik->nama }}</td>
                <td>{{ $pemilik->user ? $pemilik->user->email : 'Email tidak ditemukan' }}</td>
                <td>{{ $pemilik->jenkel }}</td>
                <td>{{ $pemilik->alamat }}</td>
                <td>{{ $pemilik->no_tlp }}</td>
                <td>
                    <a href="{{ route('admin.pemilik_hewan.edit', $pemilik->id_pemilik) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.pemilik_hewan.destroy', $pemilik->id_pemilik) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
