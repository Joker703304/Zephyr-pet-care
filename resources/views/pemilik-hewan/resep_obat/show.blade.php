@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rincian Resep Obat</h1>

    <div class="mb-3">
        <label for="id_konsultasi" class="form-label">Konsultasi</label>
        <select name="id_konsultasi" id="id_konsultasi" class="form-control" disabled>
            <option value="{{ $id_konsultasi }}">
                {{ $resepGroup->first()->konsultasi->keluhan }}
            </option>
        </select>
        <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
    </div>

    <div class="mb-3">
        <label for="diagnosis" class="form-label">Diagnosis</label>
        <select name="id_diagnosis" id="diagnosis" class="form-control" disabled>
            <option value="{{ $id_konsultasi }}">
                {{ $resepGroup->first()->konsultasi->diagnosis }}
            </option>
        </select>
        <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
    </div>

    <!-- Tabel untuk rincian resep obat -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resepGroup as $index => $resep)
            <tr>
                <td>
                    <select name="id_obat[]" id="id_obat_{{ $index }}" class="form-control" disabled>
                        <option value="{{ $resep->obat->id_obat }}">{{ $resep->obat->nama_obat }} ({{ $resep->obat->jenis_obat }})</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="jumlah[]" id="jumlah_{{ $index }}" class="form-control" value="{{ $resep->jumlah }}" disabled>
                </td>
                <td>
                    <input type="text" name="keterangan[]" id="keterangan_{{ $index }}" class="form-control" value="{{ $resep->keterangan }}" disabled>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('pemilik-hewan.resep_obat.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
