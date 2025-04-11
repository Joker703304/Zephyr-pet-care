@extends('layouts.main')

@section('content')
<div class="container">
    <h4>Laporan Transaksi</h4>

    <form method="GET" action="{{ route('admin.laporan') }}" class="d-flex align-items-center gap-2 mb-3">
        <label for="tahun">Tahun:</label>
        <input type="number" name="tahun" id="tahun" value="{{ $tahun }}" min="2020" max="2100" class="form-control">

        <div id="bulan-field" @if ($mode === 'tahun') style="display: none;" @endif>
            <label for="bulan">Bulan:</label>
            <input type="month" name="bulan" id="bulan" value="{{ $bulan }}" class="form-control">
        </div>

        <input type="hidden" name="mode" id="mode" value="{{ $mode }}">
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>

    <div class="mb-3">
        <button onclick="switchMode('bulan')" class="btn btn-outline-info @if($mode === 'bulan') active @endif">Tampilan Per Hari</button>
        <button onclick="switchMode('tahun')" class="btn btn-outline-info @if($mode === 'tahun') active @endif">Tampilan Per Tahun</button>
    </div>

    @if (($mode === 'tahun' && $rekapTahun->sum() > 0) || ($mode === 'bulan' && $transaksi->count() > 0))
    <a href="{{ route('admin.export-laporan', ['mode' => $mode, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success mb-3">
        Export ke Excel
    </a>
    <a href="{{ route('admin.laporan.pdf', ['mode' => $mode, 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger mb-3">
        Export ke PDF
    </a>
@endif


    

    @if ($mode === 'tahun')
        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Bulan</th>
                    <th>Total Uang Masuk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapTahun as $bulan => $total)
                    <tr>
                        <td>{{ \Carbon\Carbon::createFromFormat('m', $bulan)->locale('id')->translatedFormat('F') }}</td>
                        <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="table-secondary fw-bold">
                    <td>Total Seluruh Tahun {{ $tahun }}</td>
                    <td>Rp{{ number_format($totalTahun, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @elseif ($transaksi->count())
        <table class="table mt-3">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Hewan</th>
                    <th>Total Harga</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>{{ $item->konsultasi->hewan->nama_hewan ?? '-' }}</td>
                        <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->kembalian, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-3">Tidak ada data transaksi untuk periode ini.</p>
    @endif
</div>

<script>
    function switchMode(mode) {
        document.getElementById('mode').value = mode;
        if (mode === 'tahun') {
            document.getElementById('bulan-field').style.display = 'none';
        } else {
            document.getElementById('bulan-field').style.display = 'block';
        }
    }
</script>
@endsection
