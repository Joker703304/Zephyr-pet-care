@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');" minlength="10" maxlength="13"
                                   value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary w-100" id="sendOtpBtn">Send OTP</button>
                            <small id="otpStatus" class="text-muted"></small>
                        </div>

                        <div class="mb-3">
                            <label for="otp" class="form-label">{{ __('Enter OTP') }}</label>
                            <input type="text" id="otp" name="otp" class="form-control @error('otp') is-invalid @enderror"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');" minlength="6" maxlength="6" required>
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $(document).ready(function () {
        $("#sendOtpBtn").click(function () {
            let phone = $("#phone").val();
            let otpStatus = $("#otpStatus");

            if (phone.length < 10 || phone.length > 13) {
                otpStatus.text("Nomor telepon tidak valid.").addClass("text-danger");
                return;
            }

            $(this).prop("disabled", true).text("Sending...");

            $.ajax({
                url: "{{ route('send-otp') }}",
                type: "POST",
                data: {
                    phone: phone,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        otpStatus.text("OTP telah dikirim!").addClass("text-success");
                    } else {
                        otpStatus.text(response.message).addClass("text-danger");
                    }
                },
                error: function () {
                    otpStatus.text("Gagal mengirim OTP.").addClass("text-danger");
                },
                complete: function () {
                    $("#sendOtpBtn").prop("disabled", false).text("Send OTP");
                }
            });
        });
    });
</script>
@endsection

