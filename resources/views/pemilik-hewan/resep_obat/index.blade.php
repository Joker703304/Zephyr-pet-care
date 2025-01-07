@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resep Obat</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Resep</th>
                <th>Konsultasi</th>
                <th>Obat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep_obat as $resep)
            <tr>
                <td>{{ $resep->id_resep }}</td>
                <td>{{ $resep->konsultasi->keluhan }}</td>
                <td>
                    @foreach ($resep->obats as $obat)
                        <span>{{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }})</span><br>
                    @endforeach
                </td>
                <td>{{ $resep->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
