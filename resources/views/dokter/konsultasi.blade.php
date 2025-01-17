@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Konsultasi Hari Ini</h1>



        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
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
                        <td>{{ $item->keluhan }}</td>
                        <td>{{ $item->tanggal_konsultasi }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('dokter.konsultasi.diagnosis', $item->id_konsultasi) }}"
                                class="btn btn-info btn-sm">Diagnosis</a>
                            @if ($item->antrian && $item->antrian->status != 'Dipanggil')
                                <form action="{{ route('dokter.antrian.panggil', $item->antrian->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm">Panggil</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
