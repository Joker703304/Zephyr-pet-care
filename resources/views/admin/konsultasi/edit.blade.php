@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Konsultasi</h1>

    <form action="{{ route('admin.konsultasi.update', $konsultasi->id_konsultasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="dokter_id" class="form-label">Dokter</label>
            <select name="dokter_id" id="dokter_id" class="form-control">
                <option value="">Pilih Dokter</option>
                @foreach ($dokter as $item)
                    <option value="{{ $item->id }}" 
                        {{ $item->id == $konsultasi->dokter_id ? 'selected' : '' }}
                        {{ $item->status === 'Sedang Melakukan Perawatan' ? 'disabled' : '' }}>
                        {{ $item->user->name }} 
                        ({{ $item->status === 'Sedang Melakukan Perawatan' ? 'Sedang Melakukan Perawatan' : 'Tersedia' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_hewan" class="form-label">Hewan</label>
            <select name="id_hewan" id="id_hewan" class="form-control">
                @foreach ($hewan as $item)
                    <option value="{{ $item->id_hewan }}" {{ $item->id_hewan == $konsultasi->id_hewan ? 'selected' : '' }}>
                        {{ $item->nama_hewan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="3">{{ $konsultasi->keluhan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_konsultasi" class="form-label">Tanggal Konsultasi</label>
            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control" value="{{ $konsultasi->tanggal_konsultasi }}">
        </div>

        <div class="mb-3">
    <input type="hidden" name="status" id="status" value="Sedang Perawatan">
</div>

        <button type="submit" class="btn btn-success">Daftar Ulang</button>
        <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
