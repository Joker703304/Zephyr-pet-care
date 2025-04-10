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
                <td>{{ $item->total_harga }}</td>
                <td>{{ $item->jumlah_bayar }}</td>
                <td>{{ $item->kembalian }}</td>
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
                <td>{{ $total }}</td>
            </tr>
        @endforeach
        <tr>
            <td><strong>Total Tahun {{ $tahun }}</strong></td>
            <td><strong>{{ $rekapTahun->sum() }}</strong></td>
        </tr>
    </tbody>
</table>
@endif
