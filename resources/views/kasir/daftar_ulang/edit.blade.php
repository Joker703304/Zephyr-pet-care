@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Ulang</h1>

    <form action="{{ route('kasir.konsultasi.update', $konsultasi->id_konsultasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="dokter_id" class="form-label">Dokter</label>
            <input type="text" name="dokter_id" id="dokter_id" class="form-control" 
                value="{{ $konsultasi->dokter->user->name }}" readonly>
            <input type="hidden" name="dokter_id" value="{{ $konsultasi->dokter_id }}">
        </div>
        
        

        <div class="mb-3">
            <label for="id_hewan" class="form-label">Hewan</label>
            <input type="text" name="id_hewan_display" id="id_hewan_display" class="form-control" 
                value="{{ $konsultasi->hewan->nama_hewan }}" readonly>
            <input type="hidden" name="id_hewan" value="{{ $konsultasi->id_hewan }}">
        </div>
        

        <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="3">{{ $konsultasi->keluhan }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_konsultasi" class="form-label">Tanggal Konsultasi</label>
            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control" readonly value="{{ $konsultasi->tanggal_konsultasi }}">
        </div>

        <div class="mb-3">
    <input type="hidden" name="status" id="status" value="Diterima">
</div>

        <button type="submit" class="btn btn-success">Daftar Ulang</button>
        <a href="{{ route('kasir.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
