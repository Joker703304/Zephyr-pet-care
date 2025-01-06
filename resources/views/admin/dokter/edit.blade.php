@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Doctor</h1>
    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name field (Read-Only) -->
        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $dokter->user->name ?? '') }}" readonly>
        </div>

        <!-- Email field (Dropdown for selecting email) -->
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <select name="email" id="email" class="form-control" readonly  disabled>
                <option value="">-- Select Email --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->email }}" data-name="{{ $user->name }}" 
                        {{ old('email', $dokter->user->email ?? '') == $user->email ? 'selected' : '' }}>
                        {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Specialization field -->
        <div class="form-group mb-3">
            <label for="spesialis">Spesialis</label>
            <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">
        </div>

        <!-- Phone Number field -->
        <div class="form-group mb-3">
            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $dokter->no_telepon ?? '') }}" required>
        </div>

        <!-- Gender field -->
        <div class="form-group mb-3">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="pria" {{ old('jenkel', $dokter->jenkel ?? '') == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel', $dokter->jenkel ?? '') == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <!-- Address field -->
        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $dokter->alamat ?? '') }}</textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    const nameInput = document.getElementById('name');
    const emailSelect = document.getElementById('email');

    // Update name input when selecting an email
    emailSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.getAttribute('data-name');
        nameInput.value = name ? name : '';
    });
</script>
@endsection
