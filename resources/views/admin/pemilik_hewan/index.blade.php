@extends('layouts.main')

@section('content')
<div class="container">
    
    {{-- <a href="{{ route('admin.pemilik_hewan.create') }}" class="btn btn-success mb-3">Add New Owner</a> --}}

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Owner Table -->
    <table class="table table-bordered">
       
        {{-- <tbody>
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
        </tbody> --}}
    </table>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Owners Management</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
    </div>
</div>
@endsection
