@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ $user->password }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="row mb-3">
            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
        
            <div class="col-md-6">
                <select id="role" class="form-control" name="role">
                    <option value="pemilik_hewan" {{ $user->role == 'pemilik_hewan' ? 'selected' : '' }}>{{ __('Pemilik Hewan') }}</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                    <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>{{ __('Dokter') }}</option>
                    <option value="apoteker" {{ $user->role == 'apoteker' ? 'selected' : '' }}>{{ __('Apoteker') }}</option>
                </select>
            </div>
        </div>
        

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
