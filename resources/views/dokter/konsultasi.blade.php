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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konsultasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->no_antrian }}</td>
                <td>{{ $item->dokter->user->name ?? 'Tidak ada' }}</td>
                <td>{{ $item->hewan->nama_hewan ?? 'Tidak ada' }}</td>
                <td>{{ $item->diagnosis }}</td>
                <td>{{ $item->tanggal_konsultasi }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    <a href="{{ route('dokter.konsultasi.diagnosis', $item->id_konsultasi) }}" class="btn btn-info btn-sm">Diagnosis</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
