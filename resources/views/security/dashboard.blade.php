@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">MONITOR ANTRIAN</h1>

        <div class="row">
            <!-- Kolom Antrian Dipanggil -->
            <div class="col-lg-5 mb-4"> <!-- Adjusted width -->
                <h3 class="text-center">ANTRIAN DIPANGGIL</h3>
                <div class="d-flex flex-wrap justify-content-center">
                    @forelse ($antrianDipanggil as $item)
                        <div class="kotak-antrian m-3">
                            <h1>{{ strtoupper($item->no_antrian) }}</h1>
                            <p>{{ strtoupper($item->konsultasi->dokter->user->name ?? 'TIDAK ADA') }}</p>
                        </div>
                    @empty
                        <p class="text-center w-100">TIDAK ADA ANTRIAN YANG DIPANGGIL.</p>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Daftar Antrian Menunggu -->
            <div class="col-lg-7"> <!-- Adjusted width -->
                <h3 class="text-center">DAFTAR ANTRIAN MENUNGGU</h3>
                <table class="table table-bordered mt-3" id="menungguTable">
                    <thead>
                        <tr>
                            <th>NOMOR ANTRIAN</th>
                            <th>NAMA DOKTER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antrianMenunggu as $item)
                            <tr>
                                <td>{{ strtoupper($item->no_antrian) }}</td>
                                <td>{{ strtoupper($item->konsultasi->dokter->user->name ?? 'TIDAK ADA') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">BELUM ADA ANTRIAN MENUNGGU.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .kotak-antrian {
            width: 150px;
            height: 150px;
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
            font-size: 2rem;
            color: #007bff;
            font-weight: bold;
            margin: 0;
            line-height: 1;
            text-transform: uppercase;
        }
    
        .kotak-antrian p {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
        }
    
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 2rem; /* Ukuran teks diperbesar */
            font-weight: bold; /* Menambah ketebalan */
            color: #000; /* Warna teks hitam */
        }
    
        .table th {
            background-color: #007bff;
            color: #fff; /* Warna teks header tabel putih */
        }
    </style>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const fetchAntrian = () => {
            $.ajax({
                url: "{{ route('security.getAntrian') }}",
                method: "GET",
                success: function (data) {
                    const antrianDipanggilContainer = $(".d-flex.flex-wrap");
                    antrianDipanggilContainer.empty();

                    if (data.antrianDipanggil.length > 0) {
                        data.antrianDipanggil.forEach(item => {
                            const antrianBox = `
                                <div class="kotak-antrian m-3">
                                    <h1>${item.no_antrian.toUpperCase()}</h1>
                                    <p>${(item.konsultasi.dokter.user.name ?? 'TIDAK ADA').toUpperCase()}</p>
                                </div>
                            `;
                            antrianDipanggilContainer.append(antrianBox);
                        });
                    } else {
                        antrianDipanggilContainer.append('<p class="text-center w-100">TIDAK ADA ANTRIAN YANG DIPANGGIL.</p>');
                    }

                    const menungguTableBody = $("#menungguTable tbody");
                    menungguTableBody.empty();

                    if (data.antrianMenunggu.length > 0) {
                        data.antrianMenunggu.forEach(item => {
                            const row = `
                                <tr>
                                    <td>${item.no_antrian.toUpperCase()}</td>
                                    <td>${(item.konsultasi.dokter.user.name ?? 'TIDAK ADA').toUpperCase()}</td>
                                </tr>
                            `;
                            menungguTableBody.append(row);
                        });
                    } else {
                        menungguTableBody.append('<tr><td colspan="2" class="text-center">BELUM ADA ANTRIAN MENUNGGU.</td></tr>');
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
