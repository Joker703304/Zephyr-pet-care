@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Data Apoteker</h1>
    <a href="{{ route('admin.apoteker.create') }}" class="btn btn-primary mb-3">Tambah Apoteker</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($apotekers as $apoteker)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $apoteker->user->name }}</td>
                    <td>{{ $apoteker->user->email }}</td>
                    <td>{{ $apoteker->no_telepon }}</td>
                    <td>{{ ucfirst($apoteker->jenkel) }}</td>
                    <td>{{ $apoteker->alamat }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.apoteker.edit', $apoteker->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.apoteker.destroy', $apoteker->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus apoteker ini?')">Hapus</button>
                        </form> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data apoteker</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
