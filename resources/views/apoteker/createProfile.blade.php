@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lengkapi Data Anda</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('apoteker.storeProfile') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="no_telepon">Phone Number</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
        </div>

        <div class="form-group">
            <label for="jenkel">Gender</label>
            <select name="jenkel" id="jenkel" class="form-control">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="pria" {{ old('jenkel') == 'pria' ? 'selected' : '' }}>Male</option>
                <option value="wanita" {{ old('jenkel') == 'wanita' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="alamat">Address</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
