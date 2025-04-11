<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h3 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h3>Laporan Transaksi ({{ ucfirst($mode) }} - {{ $mode === 'bulan' ? $bulan : $tahun }})</h3>

    @if ($mode === 'bulan')
        <table>
            <thead>
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
        <table>
            <thead>
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
                <tr>
                    <th>Total Tahun {{ $tahun }}</th>
                    <th>Rp{{ number_format($totalTahun, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    @endif
</body>
</html>
