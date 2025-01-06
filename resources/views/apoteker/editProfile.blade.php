@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Doctor Profile</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.updateProfile') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $dokter->user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="spesialis">Specialization</label>
            <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis', $dokter->spesialis) }}" required>
        </div>

        <div class="form-group">
            <label for="no_telepon">Phone Number</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $dokter->no_telepon) }}" required>
        </div>

        <div class="form-group">
            <label for="jenkel">Gender</label>
            <select name="jenkel" id="jenkel" class="form-control">
                <option value="pria" {{ old('jenkel', $dokter->jenkel) == 'pria' ? 'selected' : '' }}>Male</option>
                <option value="wanita" {{ old('jenkel', $dokter->jenkel) == 'wanita' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Address</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $dokter->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection