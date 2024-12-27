@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Apoteker</h1>
    <form action="{{ route('admin.apoteker.update', $apoteker->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $apoteker->user->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $apoteker->no_telepon) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="pria" {{ old('jenkel', $apoteker->jenkel) === 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel', $apoteker->jenkel) === 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $apoteker->alamat) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.apoteker.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
