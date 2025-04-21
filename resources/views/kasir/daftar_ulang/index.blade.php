@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Konsultasi</h1>

    <a href="{{ route('kasir.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>
    <a href="{{ route('kasir.daftarUlang.kadaluarsa') }}" class="btn btn-danger mb-3">kadaluarsa</a>


    {{-- <a href="{{ route('admin.konsultasi.create') }}" class="btn btn-primary mb-3">Tambah Konsultasi</a> --}}

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Konsultasi</th>
                <th>NO Antrian</th>
                <th>Nama Dokter</th>
                <th>Nama Hewan</th>
                <th>Keluhan</th>
                <th>Tanggal Konsultasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konsultasi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->no_antrian }}</td>
                <td>{{ $item->dokter->user->name ?? 'Tidak ada' }}</td>
                <td>{{ $item->hewan->nama_hewan ?? 'Tidak ada' }}</td>
                <td>{{ $item->keluhan }}</td>
                <td>{{ $item->tanggal_konsultasi }}</td>
                <td>{{ $item->status }}</td>
                <td>
                    @if ($item->status === 'Menunggu')
                        <a href="{{ route('kasir.konsultasi.edit', $item->id_konsultasi) }}" class="btn btn-success btn-sm">Daftar Ulang</a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Daftar Ulang</button>
                    @endif
                    {{-- <form action="{{ route('admin.konsultasi.destroy', $item->id_konsultasi) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
