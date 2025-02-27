@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Profil Apoteker</h1>

        <!-- Success & Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Alert Container -->
        <div id="alert-container"></div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Apoteker</h5>
                        <i class="fas fa-user-circle fa-lg"></i>
                    </div>
                    <div class="card-body">
                        @if ($data->isNotEmpty())
                            @foreach ($data as $apoteker)
                                <div class="text-center mb-3">
                                    <h4 class="mt-2">{{ $apoteker->user->name }}</h4>
                                    <p class="text-muted">Apoteker</p>
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="fa fa-phone text-primary"></i>
                                        <strong>Email:</strong> {{ $apoteker->user->phone ?? 'Email tidak ditemukan' }}
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-venus-mars text-success"></i>
                                        <strong>Jenis Kelamin:</strong> {{ $apoteker->jenkel }}
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-map-marker-alt text-danger"></i>
                                        <strong>Alamat:</strong> {{ $apoteker->alamat }}
                                    </li>
                                    
                                </ul>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('apoteker.dashboard') }}" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-arrow-left"></i> Kembali
                                    </a>
                                    <a href="{{ route('apoteker.editProfile', $apoteker->id_apoteker) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit Profil
                                    </a>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalUbahPassword">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </button>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#otpModal">
                                        <i class="fa fa-phone"></i> Ubah Nomor HP
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
        <div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUbahPasswordLabel">Ubah Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Step 1: Kirim OTP -->
                        <div id="step-password-otp">
                            <form id="send-password-otp-form">
                                @csrf
                                <p>Kami akan mengirimkan kode OTP ke nomor HP Anda untuk verifikasi.</p>
                                <button type="submit" class="btn btn-primary w-100">
                                    <span id="otp-password-loading" class="spinner-border spinner-border-sm d-none"></span>
                                    Kirim OTP
                                </button>
                            </form>
                        </div>

                        <!-- Step 2: Verifikasi OTP dan Ganti Password -->
                        <div id="step-password-reset" class="d-none">
                            <form id="verify-password-otp-form">
                                @csrf
                                <input type="hidden" id="phone_for_password" name="phone">
                                <div class="mb-3">
                                    <label for="otp_code_password" class="form-label">Masukkan Kode OTP</label>
                                    <input type="text" id="otp_code_password" name="otp" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="new_password" name="password" class="form-control" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <span id="verify-password-loading"
                                        class="spinner-border spinner-border-sm d-none"></span>
                                    Verifikasi OTP & Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Nomor HP -->
        <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="otpModalLabel">Ubah Nomor HP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Step 1: Input Nomor HP -->
                        <div id="step-1">
                            <form id="send-otp-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="new_phone" class="form-label">Nomor HP Baru</label>
                                    <input type="text" id="new_phone" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <span id="otp-loading" class="spinner-border spinner-border-sm d-none"></span>
                                    Kirim OTP
                                </button>
                            </form>
                        </div>

                        <!-- Step 2: Verifikasi OTP -->
                        <div id="step-2" class="d-none">
                            <form id="verify-otp-form">
                                @csrf
                                <input type="hidden" id="otp_phone">
                                <div class="mb-3">
                                    <label for="otp_code" class="form-label">Masukkan Kode OTP</label>
                                    <input type="text" id="otp_code" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <span id="verify-loading" class="spinner-border spinner-border-sm d-none"></span>
                                    Verifikasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("send-password-otp-form").addEventListener("submit", function(event) {
            event.preventDefault();
            document.getElementById("otp-password-loading").classList.remove("d-none");

            fetch("{{ route('sendOtpChangePassword') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("otp-password-loading").classList.add("d-none");

                    if (data.success) {
                        showAlert("success", data.message);
                        document.getElementById("phone_for_password").value = data.phone;
                        document.getElementById("step-password-otp").classList.add("d-none");
                        document.getElementById("step-password-reset").classList.remove("d-none");
                    } else {
                        showAlert("danger", data.message);
                    }
                })
                .catch(error => {
                    document.getElementById("otp-password-loading").classList.add("d-none");
                    showAlert("danger", "Terjadi kesalahan, coba lagi.");
                });
        });

        document.getElementById("verify-password-otp-form").addEventListener("submit", function(event) {
            event.preventDefault();

            let phone = document.getElementById("phone_for_password").value;
            let otp = document.getElementById("otp_code_password").value;
            let newPassword = document.getElementById("new_password").value;
            let confirmPassword = document.getElementById("password_confirmation").value;

            document.getElementById("verify-password-loading").classList.remove("d-none");

            fetch("{{ route('verifyOtpChangePassword') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        phone,
                        otp,
                        password: newPassword,
                        password_confirmation: confirmPassword
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("verify-password-loading").classList.add("d-none");

                    if (data.success) {
                        showAlert("success", data.message);
                        bootstrap.Modal.getInstance(document.getElementById("modalUbahPassword")).hide();
                        location.reload();

                    } else {
                        showAlert("danger", data.message);
                    }
                })

        });

        document.getElementById("send-otp-form").addEventListener("submit", function(event) {
            event.preventDefault();

            let phone = document.getElementById("new_phone").value;
            document.getElementById("otp-loading").classList.remove("d-none");

            fetch("{{ route('sendOtpChangeNumber') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        phone: phone
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("otp-loading").classList.add("d-none");

                    if (data.success) {
                        showAlert("success", data.message);
                        document.getElementById("otp_phone").value = phone;

                        // Pindah ke form OTP
                        document.getElementById("step-1").classList.add("d-none");
                        document.getElementById("step-2").classList.remove("d-none");
                    } else {
                        showAlert("danger", data.message);
                    }
                })
                .catch(error => {
                    document.getElementById("otp-loading").classList.add("d-none");
                    showAlert("danger", "Terjadi kesalahan, coba lagi.");
                });
        });

        document.getElementById("verify-otp-form").addEventListener("submit", function(event) {
            event.preventDefault();

            let phone = document.getElementById("otp_phone").value;
            let otp = document.getElementById("otp_code").value;
            document.getElementById("verify-loading").classList.remove("d-none");

            fetch("{{ route('verifyOtpChangeNumber') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        phone: phone,
                        otp: otp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("verify-loading").classList.add("d-none");

                    if (data.success) {
                        showAlert("success", data.message);
                        document.querySelector('.no-telepon').innerText = phone;

                        // Tutup modal setelah sukses
                        bootstrap.Modal.getInstance(document.getElementById("otpModal")).hide();
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showAlert("danger", data.message);
                    }
                })

        });

        function showAlert(type, message) {
            let alertContainer = document.getElementById("alert-container");
            alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
            setTimeout(() => alertContainer.innerHTML = "", 3000);
        }

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