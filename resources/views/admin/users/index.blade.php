@extends('layouts.main')

@section('content')
<div class="container">
    <h1>User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama atau No Telepon" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>Password</th>
                <th>Role</th>
                {{-- <th>Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>********</td>
                <td>
                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="role" class="form-control" onchange="this.form.submit()">
                            <option value="pemilik_hewan" {{ $user->role == 'pemilik_hewan' ? 'selected' : '' }}>Pemilik Hewan</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="apoteker" {{ $user->role == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                            <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="security" {{ $user->role == 'security' ? 'selected' : '' }}>security</option>
                        </select>
                    </form>
                </td>
                {{-- <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span>Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}</span>
        <div>
            {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
