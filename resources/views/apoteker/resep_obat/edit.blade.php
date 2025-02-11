@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">✏️ Edit Resep Obat</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('apoteker.resep_obat.update', $id_konsultasi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_konsultasi" class="form-label">Konsultasi</label>
                <input type="text" class="form-control" value="{{ $resepGroup->first()->konsultasi->keluhan }}" disabled>
                <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
            </div>

            <div id="obat-container">
                @foreach ($resepGroup as $index => $resep)
                <div class="card mb-3 shadow-sm obat-row p-3">
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">Obat</label>
                            <select class="form-control" disabled>
                                <option value="">{{ $resep->obat->nama_obat }} ({{ $resep->obat->jenis_obat }})</option>
                            </select>
                            <input type="hidden" name="id_obat[]" value="{{ $resep->id_obat }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" value="{{ $resep->jumlah }}" disabled>
                            <input type="hidden" name="jumlah[]" value="{{ $resep->jumlah }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan[]" class="form-control" value="{{ old('keterangan.' . $index, $resep->keterangan) }}">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>        

            <input type="hidden" name="status" value="siap">

            <div class="d-flex justify-content gap-3">
                <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Resep
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .obat-row {
        border-left: 5px solid #17a2b8;
    }
    .btn-danger {
        padding: 6px 10px;
        font-size: 14px;
    }
</style>
@endsection
