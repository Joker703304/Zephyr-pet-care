@extends('layouts.main')

@section('content')
{{-- <div class="container">
    <h1>Add Doctor</h1>
    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <select name="email" id="email" class="form-control" required>
                <option value="">-- Select Email --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->email }}" data-name="{{ $user->name }}" {{ old('email') == $user->email ? 'selected' : '' }}>
                        {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="spesialis">Spesialis</label>
            <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis') }}">
        </div>

        <div class="form-group mb-3">
            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="pria" {{ old('jenkel') == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel') == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    const nameInput = document.getElementById('name');
    const emailSelect = document.getElementById('email');

    emailSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.getAttribute('data-name');
        nameInput.value = name ? name : '';
    });
</script> --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Dokter') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.dokter.register') }}">
                        @csrf

                        <!-- Input Name -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Password -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input Confirm Password -->
                        <!-- Input Confirm Password -->
<div class="row mb-3">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

    <div class="col-md-6">
        <div class="input-group">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;">
                <i class="fa fa-eye-slash"></i>
            </span>
        </div>
        @error('password')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        const confirmPasswordField = document.getElementById('password-confirm');
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
