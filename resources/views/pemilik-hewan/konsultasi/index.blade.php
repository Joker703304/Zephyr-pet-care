@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Konsultasi</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
