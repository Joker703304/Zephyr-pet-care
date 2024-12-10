@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Doctor</h1>
    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $dokter->user->name ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="spesialis">Spesialis</label>
            <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">
        </div>

        <div class="form-group mb-3">
            <label for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $dokter->no_telepon ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="hari">Hari Kerja</label><br>
            @php
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $selectedDays = old('hari', isset($dokter) ? json_decode($dokter->hari, true) : []);
            @endphp
            @foreach ($days as $day)
                <label>
                    <input type="checkbox" name="hari[]" value="{{ $day }}" 
                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                    {{ $day }}
                </label>
            @endforeach
        </div>

        <div class="form-group mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', $dokter->jam_mulai ?? '') }}">
        </div>
        
        <div class="form-group mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', $dokter->jam_selesai ?? '') }}">
        </div>
        

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
