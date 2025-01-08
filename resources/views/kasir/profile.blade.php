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
            <h5 class="mb-0">Informasi Apoteker</h5>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $kasir)
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>ID Pemilik</th>
                            <td>{{ $loop->iteration }}</td>
                        </tr> --}}
                        <tr>
                            <th>Nama</th>
                            <td>{{ $kasir->user ? $kasir->user->name : 'Nama tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $kasir->user ? $kasir->user->email : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $kasir->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $kasir->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $kasir->no_telepon }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <a href="{{ route('kasir.editProfile', $kasir->id_kasir) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('kasir.dashboard')}}" class="btn btn-secondary btn-sm">Kembali</a>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
