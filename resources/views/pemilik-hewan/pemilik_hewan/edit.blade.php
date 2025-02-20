@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h1 class="mb-4 text-center">Edit Profil Pemilik Hewan</h1> --}}

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profil</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pemilik-hewan.pemilik_hewan.update', $pemilik->id_pemilik) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="nama" id="nama" class="form-control" 
                               value="{{ old('nama', $pemilik->nama) }}" required>
                    </div>
                </div>        

                <!-- Email (Read Only) -->
                <div class="mb-3">
                    <label for="email" class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $pemilik->user->phone) }}" readonly>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jenkel" class="form-label">Jenis Kelamin</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        <select name="jenkel" id="jenkel" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="pria" {{ old('jenkel', $pemilik->jenkel) == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ old('jenkel', $pemilik->jenkel) == 'wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('pemilik-hewan.pemilik_hewan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection