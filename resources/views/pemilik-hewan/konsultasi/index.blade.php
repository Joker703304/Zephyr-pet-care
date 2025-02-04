@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Konsultasi</h1>
    <a href="{{ route('pemilik-hewan.konsultasi_pemilik.create') }}" class="btn btn-success mb-3">Ajukan Konsultasi</a>
    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Konsultasi</th>
                <th>NO Antrian</th>
                <th>Nama Dokter</th>
                <th>Nama Hewan</th>
                <th>Keluhan</th>
                <th>Tanggal Konsultasi</th>
                <th>Status</th>
                <th>Aksi</th> <!-- Kolom baru -->
            </tr>
        </thead>
        <tbody>
            @forelse ($konsultasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->no_antrian }}</td>
                <td>{{ $item->dokter->user->name ?? 'Tidak ada' }}</td>
                <td>{{ $item->hewan->nama_hewan ?? 'Tidak ada' }}</td>
                <td>{{ $item->keluhan }}</td>
                <td>{{ $item->tanggal_konsultasi }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    @if ($item->status === 'Menunggu')
                    <form action="{{ route('pemilik-hewan.konsultasi_pemilik.cancel', $item->id_konsultasi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan konsultasi ini?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data konsultasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
