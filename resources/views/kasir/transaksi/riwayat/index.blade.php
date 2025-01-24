@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Daftar Transaksi</h1>

    <a href="{{ route('kasir.transaksi.list') }}" class="btn btn-secondary mb-3">Kembali</a>
    


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
                            <!-- Tombol Bayar -->
                            

                            <!-- Modal Bayar -->
                            <div class="modal fade" id="bayarModal{{ $item->id_transaksi }}" tabindex="-1" aria-labelledby="bayarModalLabel{{ $item->id_transaksi }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('kasir.transaksi.bayar', $item->id_transaksi) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bayarModalLabel{{ $item->id_transaksi }}">Bayar Transaksi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Total Harga: <strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></p>
                                                <div class="mb-3">
                                                    <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="{{ $item->total_harga }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Bayar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Tombol Rincian -->
                            <a href="{{ route('kasir.transaksi.rincian', $item->id_transaksi) }}" class="btn btn-success btn-sm">Rincian</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
