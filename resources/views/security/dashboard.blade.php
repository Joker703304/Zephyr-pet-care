@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">Monitor Antrian</h1>

        <div class="row justify-content-center">
            @forelse ($antrianDipanggil as $item)
                <div class="kotak-antrian m-3">
                    <h1>{{ $item->no_antrian }}</h1>
                    <p>{{ $item->konsultasi->dokter->user->name ?? 'Tidak Ada' }}</p>
                </div>
            @empty
                <p class="text-center">Tidak ada antrian yang dipanggil.</p>
            @endforelse
        </div>

        <div class="mt-5">
            <h3 class="text-center">Daftar Antrian Menunggu</h3>
            <table class="table table-bordered mt-3" id="menungguTable">
                <thead>
                    <tr>
                        <th>Nomor Antrian</th>
                        <th>Nama Dokter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($antrianMenunggu as $item)
                        <tr>
                            <td>{{ $item->no_antrian }}</td>
                            <td>{{ $item->konsultasi->dokter->user->name ?? 'Tidak Ada' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Belum ada antrian menunggu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .kotak-antrian {
            width: 250px; /* Ukuran kotak dikurangi */
            height: 250px;
            background-color: #f8f9fa;
            border: 3px solid #007bff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            word-wrap: break-word;
        }

        .kotak-antrian h1 {
            font-size: 3.5rem; /* Ukuran font untuk nomor antrian dikecilkan */
            color: #007bff;
            margin: 0;
            line-height: 1;
        }

        .kotak-antrian p {
            font-size: 1rem; /* Ukuran font nama dokter dikecilkan */
            color: #333;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>

    <!-- Add this script to fetch live data -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const fetchAntrian = () => {
            $.ajax({
                url: "{{ route('security.getAntrian') }}", // URL untuk mengambil data
                method: "GET",
                success: function (data) {
                    // Update the 'Dipanggil' antrian
                    const antrianDipanggilContainer = $(".row.justify-content-center");
                    antrianDipanggilContainer.empty();

                    if (data.antrianDipanggil.length > 0) {
                        data.antrianDipanggil.forEach(item => {
                            const antrianBox = `
                                <div class="kotak-antrian m-3">
                                    <h1>${item.no_antrian}</h1>
                                    <p>${item.konsultasi.dokter.user.name ?? 'Tidak Ada'}</p>
                                </div>
                            `;
                            antrianDipanggilContainer.append(antrianBox);
                        });
                    } else {
                        antrianDipanggilContainer.append('<p class="text-center">Tidak ada antrian yang dipanggil.</p>');
                    }

                    // Update the 'Menunggu' antrian
                    const menungguTableBody = $("#menungguTable tbody");
                    menungguTableBody.empty();

                    if (data.antrianMenunggu.length > 0) {
                        data.antrianMenunggu.forEach(item => {
                            const row = `
                                <tr>
                                    <td>${item.no_antrian}</td>
                                    <td>${item.konsultasi.dokter.user.name ?? 'Tidak Ada'}</td>
                                </tr>
                            `;
                            menungguTableBody.append(row);
                        });
                    } else {
                        menungguTableBody.append('<tr><td colspan="2" class="text-center">Belum ada antrian menunggu.</td></tr>');
                    }
                },
                error: function () {
                    console.error("Gagal mengambil data antrian.");
                },
            });
        };

        // Panggil fetchAntrian setiap 5 detik
        setInterval(fetchAntrian, 5000);

        // Panggil pertama kali saat halaman dimuat
        fetchAntrian();
    </script>
@endsection
