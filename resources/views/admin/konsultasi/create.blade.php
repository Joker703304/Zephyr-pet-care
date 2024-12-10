@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Konsultasi</h1>

    <form action="{{ route('admin.konsultasi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="dokter_id" class="form-label">Nama Dokter</label>
            <select name="dokter_id" id="dokter_id" class="form-control">
                <option value="" disabled selected>Pilih Dokter</option>
                @foreach ($dokter as $item)
                    <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_hewan" class="form-label">Nama Hewan</label>
            <select name="id_hewan" id="id_hewan" class="form-control">
                <option value="" disabled selected>Pilih Hewan</option>
                @foreach ($hewan as $item)
                    <option value="{{ $item->id_hewan }}">{{ $item->nama_hewan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_konsultasi" class="form-label">Tanggal Konsultasi</label>
            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Menunggu">Menunggu</option>
                <option value="Sedang Diproses">Sedang Diproses</option>
                <option value="Selesai">Selesai</option>
                <option value="Dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.konsultasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
