@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Data Diri Anda</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

     <!-- Data Dokter -->
     <div class="card shadow mx-auto" style="max-width: 500px;"> 
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Informasi Dokter</h5>
            <i class="fas fa-user-circle fa-lg"></i>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $dokter)
                    <div class="text-center mb-3">
                        <h4 class="mt-2">{{ $dokter->user->name ?? 'Nama tidak ditemukan' }}</h4>
                        <p class="text-muted">{{ $dokter->spesialis }}</p>
                    </div>

                    <!-- Informasi Dokter dalam List Group -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fa fa-phone text-warning"></i> 
                            <strong>No Telepon:</strong> {{ $dokter->user->phone ?? 'Nomor tidak ditemukan' }}
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-venus-mars text-success"></i> 
                            <strong>Jenis Kelamin:</strong> {{ $dokter->jenkel }}
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-map-marker-alt text-danger"></i> 
                            <strong>Alamat:</strong> {{ $dokter->alamat }}
                        </li>
                        
                    </ul>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('dokter.dashboard')}}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('dokter.editProfile', $dokter->id_dokter) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit Profil
                        </a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>
     <!-- Modal Ubah Password -->
    @if($data->isNotEmpty())
    @foreach($data as $dokter)
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <form method="POST" action="{{ route('dokter.update-password', $dokter->id) }}">
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
                               <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                   <i class="fa fa-eye-slash"></i>
                               </button>
                           </div>
                       </div>
                       <div class="mb-3">
                           <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                           <div class="input-group">
                               <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                               <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                   <i class="fa fa-eye-slash"></i>
                               </button>
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
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });

    // Toggle Confirm Password Visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const confirmPasswordField = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            confirmPasswordField.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>
@endsection
