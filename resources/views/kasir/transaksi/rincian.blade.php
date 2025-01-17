<div class="container py-4">
    <div class="receipt" id="receiptContent">
        <div class="header">
            <div class="store-info">
                <h3>Zhepyr Pet Care</h3>
            </div>
            <div class="transaction-info">
                <p><strong>No. Transaksi:</strong> {{ $transaksi->id_transaksi }}</p>
                <p><strong>Tanggal:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                <p><strong>Nama Pemilik Hewan:</strong> {{ $transaksi->konsultasi->hewan->pemilik->nama ?? 'N/A' }}</p>
                <p><strong>Nomor Antrian:</strong> {{ $transaksi->konsultasi->no_antrian ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="dashed-line"></div>

        <div class="items">
            <h5>Daftar Layanan dan Obat:</h5>
            <ul>
                @foreach ($transaksi->konsultasi->layanan as $index => $layanan)
                    <li>
                        <span>{{ $index + 1 }}. {{ $layanan->nama_layanan }}</span>
                        <span class="price">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                    </li>
                @endforeach

                @forelse ($transaksi->konsultasi->resepObat as $index => $resep)
                    <li>
                        <span>{{ $index + 1 + count($transaksi->konsultasi->layanan) }}. {{ $resep->obat->nama_obat }}   ({{ $resep->jumlah }})</span>
                        <span class="price">Rp {{ number_format($resep->jumlah * $resep->obat->harga, 0, ',', '.') }}</span>
                    </li>
                @empty
                    <li>Tidak ada obat.</li>
                @endforelse
            </ul>
        </div>

        <div class="dashed-line"></div>

        <div class="totals">
            <p><strong>Total QTY:</strong> {{ count($transaksi->konsultasi->layanan) + count($transaksi->konsultasi->resepObat) }}</p>
            <p><strong>Sub Total:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

            @if ($transaksi->status_pembayaran === 'Sudah Dibayar')
                <p><strong>Bayar (Cash):</strong> Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</p>
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->jumlah_bayar - $transaksi->total_harga, 0, ',', '.') }}</p>
            @endif
        </div>

        <div class="dashed-line"></div>

        <div class="footer text-center">
            <p>Terima kasih Telah Berbelanja!</p>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-3">
            <button onclick="window.print()">Print Receipt</button>
        </div>
    </div>
</div>

<style>
    .receipt {
        font-family: Arial, sans-serif;
        width: 100%;
        max-width: 400px;
        margin: auto;
        padding: 15px;
        border: 1px solid #ddd;
        box-sizing: border-box;
    }

    .header {
        display: flex;
        justify-content: space-between;
    }

    .store-info, .transaction-info {
        font-size: 8px;
    }

    .store-info h3 {
        margin-bottom: 0;
    }

    .dashed-line {
        margin: 8px 0;
        border-bottom: 1px dashed #ddd;
    }

    .items ul {
        list-style-type: none;
        padding: 0;
        font-size: 8px;
    }

    .items ul li {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
    }

    .items ul li span {
        display: inline-block;
    }

    .price {
        text-align: right;
    }

    .totals p {
        font-size: 8px;
        display: flex;
        justify-content: space-between;
    }

    .footer {
        font-size: 8px;
        margin-top: 15px;
    }

    .footer a {
        text-decoration: none;
    }

    @media print {
        /* Hide print button */
        button {
            display: none !important;
        }

        /* Adjust receipt width and font size for print */
        .receipt {
            width: 100%;
            max-width: 300px;
            font-size: 6px;
            margin: 0 !important;
            padding: 10px;
            border: none !important; /* Remove border when printing */
            box-sizing: border-box;
        }

        /* Prevent clipping on sides */
        @page {
            size: auto;
            margin: 0;
        }

        /* Ensure dashed line is consistent for print */
        .dashed-line {
            border-bottom: 1px dashed #ddd !important;
        }

        /* Ensure all sections look clean in print */
        .header, .items, .totals, .footer {
            font-size: 6px !important;
        }

        .items ul li {
            padding: 2px 0 !important;
        }

        .footer {
            margin-top: 10px !important;
        }
    }
</style>