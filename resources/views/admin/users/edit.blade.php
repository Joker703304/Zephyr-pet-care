@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" class="form-control" name="role">
                <option value="pemilik_hewan" {{ $user->role == 'pemilik_hewan' ? 'selected' : '' }}>{{ __('Pemilik Hewan') }}</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>{{ __('Dokter') }}</option>
                <option value="apoteker" {{ $user->role == 'apoteker' ? 'selected' : '' }}>{{ __('Apoteker') }}</option>
            </select>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
