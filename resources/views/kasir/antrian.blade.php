@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center mb-4">Data Antrian Hari Ini</h1>

        <a href="{{ route('kasir.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor Antrian</th>
                    <th>Nama Dokter</th>
                    <th>Status</th>
                    <th>Waktu Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($antrian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_antrian }}</td>
                        <td>{{ $item->konsultasi->dokter->user->name ?? 'Tidak Ada' }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @if ($item->status == 'Dipanggil')
                                <form action="{{ route('kasir.antrian.selesai', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                </form>
                                @elseif ($item->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada antrian untuk hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
