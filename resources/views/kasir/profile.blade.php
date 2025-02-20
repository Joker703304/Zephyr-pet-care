@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Diri Anda</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div id="alert-container"></div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Kasir</h5>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $kasir)
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $kasir->user ? $kasir->user->name : 'Nama tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td class="no-telepon">{{ $kasir->user ? $kasir->user->phone : 'Nomor tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $kasir->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $kasir->alamat }}</td>
                        </tr>
                    </table>
                    <div class="d-flex gap-2">
                        <a href="{{ route('kasir.editProfile', $kasir->id_kasir) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('kasir.dashboard')}}" class="btn btn-secondary btn-sm">Kembali</a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Ubah Password</button>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#otpModal">Ubah Nomor HP</button>
                    </div>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>

    @if($data->isNotEmpty())
        @foreach($data as $kasir)
        <div class="modal fade" id="changePasswordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('kasir.update-password', $kasir->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    <div class="modal fade" id="otpModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Nomor HP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="step-1">
                        <form id="send-otp-form">
                            @csrf
                            <div class="mb-3">
                                <label>Nomor HP Baru</label>
                                <input type="text" id="new_phone" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim OTP</button>
                        </form>
                    </div>
                    <div id="step-2" class="d-none">
                        <form id="verify-otp-form">
                            @csrf
                            <input type="hidden" id="otp_phone">
                            <div class="mb-3">
                                <label>Masukkan Kode OTP</label>
                                <input type="text" id="otp_code" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("send-otp-form").addEventListener("submit", function(event) {
    event.preventDefault();
    let phone = document.getElementById("new_phone").value;
    fetch("{{ route('sendOtpChangeNumber') }}", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: JSON.stringify({ phone: phone })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("otp_phone").value = phone;
            document.getElementById("step-1").classList.add("d-none");
            document.getElementById("step-2").classList.remove("d-none");
        } else {
            alert(data.message);
        }
    });
});

document.getElementById("verify-otp-form").addEventListener("submit", function(event) {
    event.preventDefault();
    let phone = document.getElementById("otp_phone").value;
    let otp = document.getElementById("otp_code").value;
    fetch("{{ route('verifyOtpChangeNumber') }}", {
        method: "POST",
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        body: JSON.stringify({ phone: phone, otp: otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector('.no-telepon').innerText = phone;
            bootstrap.Modal.getInstance(document.getElementById("otpModal")).hide();
        } else {
            alert(data.message);
        }
    });
});
</script>
@endsection
