@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Profil Anda</h1>

    <!-- Success & Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Pemilik Hewan</h5>
                    <i class="fas fa-user-circle fa-lg"></i>
                </div>
                <div class="card-body">
                    @if($data->isNotEmpty())
                        @foreach($data as $pemilik)
                        <div class="text-center mb-3">
                            <h4 class="mt-2">{{ $pemilik->nama }}</h4>
                            <p class="text-muted">Pemilik Hewan</p>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa fa-envelope text-primary"></i> 
                                <strong>Email:</strong> {{ $pemilik->user->email ?? 'Email tidak ditemukan' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-venus-mars text-success"></i> 
                                <strong>Jenis Kelamin:</strong> {{ $pemilik->jenkel }}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-map-marker-alt text-danger"></i> 
                                <strong>Alamat:</strong> {{ $pemilik->alamat }}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-phone text-warning"></i> 
                                <strong>No Telepon:</strong> {{ $pemilik->no_tlp }}
                            </li>
                        </ul>                        

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('pemilik-hewan.pemilik_hewan.edit', $pemilik->id_pemilik) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit Profil
                            </a>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbahPassword">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                        @endforeach
                    @else
                        <p class="text-center">Data diri tidak ditemukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Password -->
    @if($data->isNotEmpty())
        @foreach($data as $pemilik)
        <div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('pemilik-hewan.update-password', $pemilik->id_pemilik) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUbahPasswordLabel">Ubah Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script>
    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (inputField.type === 'password') {
                inputField.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                inputField.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>
@endsection