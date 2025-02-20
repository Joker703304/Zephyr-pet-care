@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">MONITOR ANTRIAN</h1>

        <div class="row">
            <!-- Kolom Antrian Dipanggil -->
            <div class="col-lg-8 mb-4">
                <h3 class="text-center">ANTRIAN DIPANGGIL</h3>
                <div class="d-flex flex-wrap justify-content-center" id="antrianDipanggil">
                    @forelse ($antrianDipanggil as $item)
                        <div class="kotak-antrian m-3">
                            <h1>{{ strtoupper($item->no_antrian) }}</h1>
                            <p>{{ strtoupper($item->konsultasi->hewan->pemilik->nama ?? 'TIDAK ADA') }}</p>
                            <p>{{ strtoupper($item->konsultasi->hewan->nama_hewan ?? 'TIDAK ADA') }}</p>
                            @if ($item->konsultasi->status == 'Pembayaran')
                                <p class="kasir text-success">KASIR</p>
                            @else
                                <p class="text-primary">{{ strtoupper($item->konsultasi->dokter->user->name ?? 'TIDAK ADA') }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-center w-100">TIDAK ADA ANTRIAN YANG DIPANGGIL.</p>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Daftar Antrian Menunggu -->
            <div class="col-lg-4">
                <h3 class="text-center">DAFTAR ANTRIAN MENUNGGU</h3>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>NOMOR ANTRIAN</th>
                        </tr>
                    </thead>
                    <tbody id="menungguTable">
                        @forelse ($antrianMenunggu as $item)
                            @if ($item->konsultasi->status !== 'Selesai')
                                <tr>
                                    <td>{{ strtoupper($item->no_antrian) }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">BELUM ADA ANTRIAN UNTUK SAAT INI.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .kotak-antrian {
            width: 230px;
            height: 230px;
            background-color: #f8f9fa;
            border: 3px solid #007bff;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            word-wrap: break-word;
        }

        .kotak-antrian h1 {
            font-size: 2.5rem;
            color: #007bff;
            font-weight: bold;
            margin: 0;
            line-height: 1;
            text-transform: uppercase;
        }

        .kotak-antrian p {
            font-size: 2rem;
            color: #333;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
        }

        .text-primary {
            color: blue !important; /* Nama dokter jadi biru */
            font-weight: bold;
        }

        .text-success {
            color: green !important; /* Kasir jadi hijau */
            font-weight: bold;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 2rem;
            font-weight: bold;
            color: #000;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const fetchAntrian = () => {
            $.ajax({
                url: "{{ route('security.getAntrian') }}",
                method: "GET",
                success: function (data) {
                    const antrianDipanggilContainer = $("#antrianDipanggil");
                    antrianDipanggilContainer.empty();

                    if (data.antrianDipanggil.length > 0) {
                        data.antrianDipanggil.forEach(item => {
                            let statusPembayaran = item.konsultasi.status_pembayaran == 'Belum Lunas' 
                                ? '<p class="kasir text-success">Silakan ke kasir</p>' 
                                : `<p class="text-primary">${(item.konsultasi.dokter.user.name ?? 'TIDAK ADA').toUpperCase()}</p>`;

                            const antrianBox = `
                                <div class="kotak-antrian m-3">
                                    <h1>${item.no_antrian.toUpperCase()}</h1>
                                    <p>${(item.konsultasi.hewan.pemilik. ?? 'TIDAK ADA').toUpperCase()}</p>
                                    <p>${(item.konsultasi.hewan.nama_hewan ?? 'TIDAK ADA').toUpperCase()}</p>
                                    ${statusPembayaran}
                                </div>
                            `;
                            antrianDipanggilContainer.append(antrianBox);
                        });
                    } else {
                        antrianDipanggilContainer.append('<p class="text-center w-100">TIDAK ADA ANTRIAN YANG DIPANGGIL.</p>');
                    }

                    const menungguTableBody = $("#menungguTable");
                    menungguTableBody.empty();

                    if (data.antrianMenunggu.length > 0) {
                        data.antrianMenunggu.forEach(item => {
                            if (item.konsultasi.status !== "Selesai") {
                                let dokterName = item.konsultasi.status_pembayaran !== 'Belum Lunas' 
                                    ? `<span class="text-primary">${(item.konsultasi.dokter.user.name ?? 'TIDAK ADA').toUpperCase()}</span>` 
                                    : '';

                                const row = `
                                    <tr>
                                        <td>${item.no_antrian.toUpperCase()}</td>
                                        <td>${dokterName}</td>
                                    </tr>
                                `;
                                menungguTableBody.append(row);
                            }
                        });
                    } else {
                        menungguTableBody.append('<tr><td colspan="2" class="text-center">BELUM ADA ANTRIAN UNTUK SAAT INI.</td></tr>');
                    }
                },
                error: function () {
                    console.error("GAGAL MENGAMBIL DATA ANTRIAN.");
                },
            });
        };

        setInterval(fetchAntrian, 5000);
        fetchAntrian();
    </script>
@endsection
