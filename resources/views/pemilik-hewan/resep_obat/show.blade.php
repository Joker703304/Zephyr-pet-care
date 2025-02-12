@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">📜 Rincian Resep Obat</h1>

    <div class="mb-3">
        <label for="id_konsultasi" class="form-label fw-bold"><i class="fas fa-comment-medical"></i> Konsultasi</label>
        <select name="id_konsultasi" id="id_konsultasi" class="form-control" disabled>
            <option value="{{ $id_konsultasi }}">
                {{ $resepGroup->first()->konsultasi->keluhan }}
            </option>
        </select>
        <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
    </div>

    <div class="mb-3">
        <label for="diagnosis" class="form-label fw-bold"><i class="fas fa-notes-medical"></i> Diagnosis</label>
        <select name="id_diagnosis" id="diagnosis" class="form-control" disabled>
            <option value="{{ $id_konsultasi }}">
                {{ $resepGroup->first()->konsultasi->diagnosis }}
            </option>
        </select>
        <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
    </div>

    <!-- Tabel untuk rincian resep obat -->
    <div class="table-container">
        <table class="table table-bordered align-middle fixed-table">
            <thead class="table-light">
                <tr>
                    <th class="obat-column">Obat</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resepGroup as $index => $resep)
                <tr>
                    <td class="text-break">
                        <select name="id_obat[]" id="id_obat_{{ $index }}" class="form-control" disabled>
                            <option value="{{ $resep->obat->id_obat }}">
                                {{ $resep->obat->nama_obat }} ({{ $resep->obat->jenis_obat }})
                            </option>
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="number" name="jumlah[]" id="jumlah_{{ $index }}" 
                               class="form-control text-center" value="{{ $resep->jumlah }}" disabled>
                    </td>
                    <td>
                        <input type="text" name="keterangan[]" id="keterangan_{{ $index }}" 
                               class="form-control" value="{{ $resep->keterangan }}" disabled>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-start mt-3">
        <a href="{{ route('pemilik-hewan.resep_obat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- CSS agar tabel tidak bisa digeser -->
<style>
    .table-container {
        width: 100%;
    }

    .fixed-table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    .obat-column {
        width: 40%; /* Atur lebar kolom agar lebih proporsional */
    }

    .table th, .table td {
        word-wrap: break-word;
        white-space: normal; /* Pastikan teks turun ke bawah */
    }

    select.form-control {
        width: 100%;
        white-space: normal; /* Memungkinkan teks turun ke baris berikutnya */
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    @media (max-width: 576px) {
        h1 {
            font-size: 20px;
        }

        .form-label {
            font-size: 14px;
        }

        .table th, .table td {
            font-size: 13px;
        }

        .btn {
            font-size: 14px;
            padding: 6px 12px;
        }
    }
</style>
@endsection