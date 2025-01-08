@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Diri Anda</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Pemilik Hewan -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Dokter</h5>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $dokter)
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>ID Pemilik</th>
                            <td>{{ $loop->iteration }}</td>
                        </tr> --}}
                        <tr>
                            <th>Nama</th>
                            <td>{{ $dokter->user ? $dokter->user->name : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Sepesialis</th>
                            <td>{{ $dokter->spesialis }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $dokter->user ? $dokter->user->email : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $dokter->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $dokter->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $dokter->no_telepon }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <a href="{{ route('dokter.editProfile', $dokter->id_dokter) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Kembali</a>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
