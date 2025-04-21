@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">MONITOR ANTRIAN</h1>

        <div class="row">
            <!-- Kolom Antrian Dipanggil -->
            <div class="col-lg-8 mb-4">
                <h3 class="text-center">ANTRIAN DIPANGGIL</h3>
                <div class="d-flex flex-wrap justify-content-center" id="antrianDipanggil">
                    <!-- Data AJAX -->
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
                        <!-- Data AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Gaya --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');

        .kotak-antrian {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            border: none;
            box-shadow: 0 8px 16px rgba(0, 123, 255, 0.3);
            border-radius: 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .kotak-antrian.animate {
            animation: fadeInUp 0.5s ease;
        }

        .kotak-antrian:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.5);
        }

        .kotak-antrian h1 {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .kotak-antrian p {
            font-size: 1.5rem;
            margin: 0;
            color: #333;
            text-overflow: ellipsis;
            overflow: hidden;
            max-width: 100%;
            white-space: nowrap;
        }

        .kasir {
            color: #28a745 !important;
            font-weight: bold;
            font-size: 1.4rem;
            margin-top: 10px;
        }

        .text-primary {
            color: #007bff !important;
            font-weight: bold;
            font-size: 1.4rem;
            margin-top: 10px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    {{-- AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let lastDipanggilHTML = '';
        let lastMenungguHTML = '';

        function fetchAntrian() {
            $.ajax({
                url: "{{ route('security.getAntrian') }}",
                method: 'GET',
                success: function (data) {
                    const dipanggil = data.antrianDipanggil;
                    const menunggu = data.antrianMenunggu;

                    // Antrian Dipanggil
                    let htmlDipanggil = '';
                    if (dipanggil.length > 0) {
                        dipanggil.forEach(item => {
                            const pemilik = item.konsultasi?.hewan?.pemilik?.nama ?? 'TIDAK ADA';
                            const hewan = item.konsultasi?.hewan?.nama_hewan ?? 'TIDAK ADA';
                            const dokter = item.konsultasi?.dokter?.user?.name ?? 'TIDAK ADA';
                            const status = item.konsultasi?.status === 'Pembayaran'
                                ? '<p class="kasir text-success">KASIR</p>'
                                : `<p class="text-primary">${dokter.toUpperCase()}</p>`;

                            htmlDipanggil += `
                                <div class="kotak-antrian animate m-3">
                                    <h1>${item.no_antrian.toUpperCase()}</h1>
                                    <p><i class="fas fa-user"></i> ${pemilik.toUpperCase()}</p>
                                    <p><i class="fas fa-paw"></i> ${hewan.toUpperCase()}</p>
                                    ${status}
                                </div>
                            `;
                        });
                    } else {
                        htmlDipanggil = '<p class="text-center w-100">TIDAK ADA ANTRIAN YANG DIPANGGIL.</p>';
                    }

                    if (htmlDipanggil !== lastDipanggilHTML) {
                        $('#antrianDipanggil').html(htmlDipanggil);
                        lastDipanggilHTML = htmlDipanggil;
                    }

                    // Antrian Menunggu
                    let htmlMenunggu = '';
                    if (menunggu.length > 0) {
                        menunggu.forEach(item => {
                            if (item.konsultasi?.status !== 'Selesai') {
                                htmlMenunggu += `
                                    <tr>
                                        <td>${item.no_antrian.toUpperCase()}</td>
                                    </tr>
                                `;
                            }
                        });
                    }
                    if (htmlMenunggu === '') {
                        htmlMenunggu = '<tr><td colspan="2" class="text-center">BELUM ADA ANTRIAN UNTUK SAAT INI.</td></tr>';
                    }

                    if (htmlMenunggu !== lastMenungguHTML) {
                        $('#menungguTable').html(htmlMenunggu);
                        lastMenungguHTML = htmlMenunggu;
                    }
                },
                error: function () {
                    console.error('GAGAL MENGAMBIL DATA ANTRIAN.');
                }
            });
        }

        setInterval(fetchAntrian, 5000);
        $(document).ready(fetchAntrian);
    </script>
@endsection
