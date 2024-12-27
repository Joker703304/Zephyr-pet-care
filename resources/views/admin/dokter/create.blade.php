@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Doctor</h1>
    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="id_user">Pilih Dokter</label>
            <select name="id_user" id="id_user" class="form-control" required>
                <option value="">-- Pilih Dokter --</option>
                @foreach ($emails as $id => $email)
                    <option value="{{ $id }}" {{ old('id_user') == $id ? 'selected' : '' }}>
                        {{ $email }}
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
            <label for="hari">Hari Kerja</label><br>
            @php
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            @endphp
            @foreach ($days as $day)
                <label>
                    <input type="checkbox" name="hari[]" value="{{ $day }}" {{ in_array($day, old('hari', [])) ? 'checked' : '' }}>
                    {{ $day }}
                </label>
            @endforeach
        </div>

        <div class="form-group mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
        </div>

        <div class="form-group mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
