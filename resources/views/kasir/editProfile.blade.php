@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kasir Profile</h1>

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

    <form action="{{ route('kasir.updateProfile') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $kasir->user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="no_telepon">Nomor HP</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $kasir->no_telepon) }}" required>
        </div>

        <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control">
                <option value="" >Pilih Jenis Kelamin</option>
                <option value="pria" {{ old('jenkel', $kasir->jenkel) == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel', $kasir->jenkel) == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $kasir->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
