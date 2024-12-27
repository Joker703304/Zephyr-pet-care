@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Apoteker</h1>
    <form action="{{ route('admin.apoteker.store') }}" method="POST">
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
            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="">-- Select Gender --</option>
                <option value="pria" {{ old('jenkel') == 'pria' ? 'selected' : '' }}>Pria</option>
                <option value="wanita" {{ old('jenkel') == 'wanita' ? 'selected' : '' }}>Wanita</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.apoteker.index') }}" class="btn btn-secondary">Cancel</a>
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
</script>
@endsection
