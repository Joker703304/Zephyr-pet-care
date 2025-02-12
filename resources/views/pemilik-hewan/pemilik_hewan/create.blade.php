@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Lengkapi data Anda</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
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

    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('pemilik-hewan.pemilik_hewan.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label"><i class="fa fa-user"></i> Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $user->name) }}" required>
                </div>

                <!-- Email (Read Only) -->
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fa fa-envelope"></i> Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required readonly>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jenkel" class="form-label"><i class="fa fa-venus-mars"></i> Jenis Kelamin</label>
                    <select name="jenkel" id="jenkel" class="form-select">
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="pria" {{ old('jenkel') == 'pria' ? 'selected' : '' }}>Pria</option>
                        <option value="wanita" {{ old('jenkel') == 'wanita' ? 'selected' : '' }}>Wanita</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label"><i class="fa fa-map-marker-alt"></i> Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                </div>

                <!-- Nomor Telepon -->
                

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    {{-- <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Batal
                    </a> --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection