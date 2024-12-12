@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Resep Obat</h1>

    <form action="{{ route('apoteker.resep_obat.update', $resepObat->id_resep) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="id_konsultasi" class="form-label">Konsultasi</label>
            <select name="id_konsultasi" id="id_konsultasi" class="form-control @error('id_konsultasi') is-invalid @enderror">
                <option value="">Pilih Konsultasi</option>
                @foreach ($konsultasi as $item)
                    <option value="{{ $item->id_konsultasi }}" {{ old('id_konsultasi', $resepObat->id_konsultasi) == $item->id_konsultasi ? 'selected' : '' }}>
                        No Antrian: {{ $item->no_antrian }} - {{ $item->keluhan }}
                    </option>
                @endforeach
            </select>
            @error('id_konsultasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="id_obat" class="form-label">Obat</label>
            <select name="id_obat" id="id_obat" class="form-control @error('id_obat') is-invalid @enderror">
                <option value="">Pilih Obat</option>
                @foreach ($obat as $item)
                    <option value="{{ $item->id_obat }}" {{ old('id_obat', $resepObat->id_obat) == $item->id_obat ? 'selected' : '' }}>
                        {{ $item->nama_obat }} ({{ $item->jenis_obat }})
                    </option>
                @endforeach
            </select>
            @error('id_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $resepObat->jumlah) }}">
            @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $resepObat->keterangan) }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Resep Obat</button>
        <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
