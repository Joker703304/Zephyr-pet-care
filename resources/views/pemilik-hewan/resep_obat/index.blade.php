@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resep Obat</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- <a href="{{ route('apoteker.resep_obat.history') }}" class="btn btn-info mb-3">Lihat History Resep Obat</a> --}}
    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Resep</th>
                <th>Hewan</th>
                <th>Konsultasi</th>
                <th>Diagnosis</th>
                <th>Obat</th>
                {{-- <th>Status</th>  <!-- Kolom Status --> --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep_obat as $id_konsultasi => $resepGroup)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $resepGroup->first()->konsultasi->hewan->nama_hewan }}</td>
                <td>{{ $resepGroup->first()->konsultasi->keluhan }}</td>
                <td>{{ $resepGroup->first()->konsultasi->diagnosis }}</td>
                <td>
                    @foreach ($resepGroup as $resep)
                        <span>{{ $resep->obat->nama_obat }} ({{ $resep->jumlah }})</span><br>
                    @endforeach
                </td>
                {{-- <td>
                    @foreach ($resepGroup as $resep)
                    <span>{{ $resep->keterangan }}</span><br>
                    @endforeach
                </td> --}}
                {{-- <td>
                    <!-- Menampilkan status resep -->
                    <span class="badge 
                        @if($resepGroup->first()->status == 'sedang disiapkan') badge-warning 
                        @elseif($resepGroup->first()->status == 'selesai') badge-success
                        @else badge-secondary
                        @endif status-badge">
                        {{ ucfirst($resepGroup->first()->status) ?? 'Sedang di Siapkan' }}
                    </span>
                </td> --}}
                <td>
                    <a href="{{ route('pemilik-hewan.resep_obat.show', $resep->id_konsultasi) }}" class="btn btn-info">Lihat Rincian</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Tambahkan style di sini -->
<style>
    .status-badge {
        color: black;  /* Set warna teks menjadi hitam */
    }
</style>
@endsection
