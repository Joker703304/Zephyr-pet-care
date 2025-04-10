@extends('layouts.main')

@section('content')
<div class="container">
    <h1>User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter Section -->
    <div class="row mb-3">
        <!-- Search Bar -->
        <div class="col-md-4">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau No Telepon" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <!-- Filter Role -->
        <div class="col-md-3">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <select name="role" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Role --</option>
                    <option value="pemilik_hewan" {{ request('role') == 'pemilik_hewan' ? 'selected' : '' }}>Pemilik Hewan</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="apoteker" {{ request('role') == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                    <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="security" {{ request('role') == 'security' ? 'selected' : '' }}>Security</option>
                </select>
            </form>
        </div>

        <!-- Reset Button -->
        <div class="col-md-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>

    <div class="card shadow rounded">
    <div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Pengguna</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            Nama {!! request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'phone', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                            No Telepon {!! request('sort') == 'phone' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                        </a>
                    </th>
                    <th>Password</th>
                    <th>Role</th>
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
                                <option value="security" {{ $user->role == 'security' ? 'selected' : '' }}>Security</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    


    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span>Halaman {{ $users->currentPage() }} dari {{ $users->lastPage() }}</span>
        <div>
            {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
