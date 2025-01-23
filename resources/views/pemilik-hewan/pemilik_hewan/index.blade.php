@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Diri Anda</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Pemilik Hewan -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Pemilik Hewan</h5>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $pemilik)
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>ID Pemilik</th>
                            <td>{{ $loop->iteration }}</td>
                        </tr> --}}
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pemilik->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pemilik->user ? $pemilik->user->email : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pemilik->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pemilik->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $pemilik->no_tlp }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <a href="{{ route('pemilik-hewan.pemilik_hewan.edit', $pemilik->id_pemilik) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary btn-sm">Kembali</a>

                    <!-- Button to Open Password Modal -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbahPassword">
                        Ubah Password
                    </button>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
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