@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Buat Profile Security</h3>
            </div>
            <div class="card-body p-4">

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Warning Message -->
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('security.storeProfile') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama" id="nama" 
                                class="form-control @error('nama') is-invalid @enderror" 
                                value="{{ old('nama', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                   <!-- Nomor Telepon -->
                   <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" name="phone" id="phone" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            value="{{ old('phone', $user->phone) }}" placeholder="Masukan No.Tlp" readonly>
                    </div>
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label for="jenkel" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            <select name="jenkel" id="jenkel" class="form-control @error('jenkel') is-invalid @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="pria" {{ old('jenkel') == 'pria' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="wanita" {{ old('jenkel') == 'wanita' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenkel')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <textarea name="alamat" id="alamat" 
                                class="form-control @error('alamat') is-invalid @enderror" 
                                placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan agar lebih user-friendly */
    .card {
        max-width: 600px;
        margin: auto;
    }

    .input-group-text {
        background-color: #f8f9fa;
    }

    .btn-primary {
        font-size: 1.1rem;
    }
</style>
@endsection
