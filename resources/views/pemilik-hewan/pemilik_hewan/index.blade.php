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
            <h5 class="mb-0">Informasi Pemilik Hewan</h5>
        </div>
        <div class="card-body">
            @if($data->isNotEmpty())
                @foreach($data as $pemilik)
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>ID Pemilik</th>
                            <td>{{ $loop->iteration }}</td>
                        </tr> --}}
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pemilik->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $pemilik->user ? $pemilik->user->email : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pemilik->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pemilik->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $pemilik->no_tlp }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <a href="{{ route('pemilik-hewan.pemilik_hewan.edit', $pemilik->id_pemilik) }}" class="btn btn-warning btn-sm">Edit</a>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
