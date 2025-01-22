@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Daftar Transaksi</h1>

    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pemilik</th>
                <th>No Antrian</th>
                <th>ID Transaksi</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td>{{ $item->konsultasi->hewan->pemilik->nama }}</td>
                    <td>{{ $item->konsultasi->no_antrian }}</td>
                    <td>{{ $item->id_transaksi }}</td>
                    <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($item->status_pembayaran) }}</td>
                    <td>
                        @if ($item->status_pembayaran === 'Belum Dibayar')
                            
                        @else
                            <!-- Tombol Rincian -->
                            <a href="{{ route('pemilik-hewan.transaksi.rincian', $item->id_transaksi) }}" class="btn btn-success btn-sm">Rincian</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
