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
                @foreach($data as $security)
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>ID Pemilik</th>
                            <td>{{ $loop->iteration }}</td>
                        </tr> --}}
                        <tr>
                            <th>Nama</th>
                            <td>{{ $security->user ? $security->user->name : 'Nama tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $security->user ? $security->user->email : 'Email tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $security->jenkel }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $security->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>{{ $security->no_telepon }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <a href="{{ route('security.editProfile', $security->id_security) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('security.dashboard')}}" class="btn btn-secondary btn-sm">Kembali</a>
                @endforeach
            @else
                <p class="text-center">Data diri tidak ditemukan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
