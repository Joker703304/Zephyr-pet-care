@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <h1 class="mb-4 text-center">Edit Profil Dokter</h1> --}}

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
            <h5 class="mb-0"><i class="fas fa-user-md"></i> Edit Profil</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dokter.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" id="name" class="form-control" 
                               value="{{ old('name', $dokter->user->name) }}" required>
                    </div>
                </div>

                <!-- Spesialis -->
                <div class="mb-3">
                    <label for="spesialis" class="form-label">Spesialis</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                        <input type="text" name="spesialis" id="spesialis" class="form-control" 
                               value="{{ old('spesialis', $dokter->spesialis) }}" required>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-3">
                    <label for="no_telepon" class="form-label">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control" 
                               value="{{ old('no_telepon', $dokter->no_telepon) }}" required>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jenkel" class="form-label">Jenis Kelamin</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        <select name="jenkel" id="jenkel" class="form-control">
                            <option value="pria" {{ old('jenkel', $dokter->jenkel) == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ old('jenkel', $dokter->jenkel) == 'wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $dokter->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2">
                    <a href="javascript:history.back()" class="btn btn-secondary">
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