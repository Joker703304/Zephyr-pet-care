@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Owner</h1>

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

    <form action="{{ route('admin.pemilik_hewan.update', $pemilik->id_pemilik) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pemilik->nama) }}" required>
        </div>        

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pemilik->email) }}" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control">
                <option value="pria" {{ old('jenkel', $pemilik->jenkel) == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel', $pemilik->jenkel) == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
        </div>

        <!-- Nomor Telepon -->
        <div class="form-group">
            <label for="no_tlp">Nomor Telepon</label>
            <input type="text" name="no_tlp" id="no_tlp" class="form-control" value="{{ old('no_tlp', $pemilik->no_tlp) }}" required>
        </div>

        <!-- Buttons -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.pemilik_hewan.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
