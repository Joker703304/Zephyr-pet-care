@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajukan Konsultasi</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pemilik-hewan.konsultasi_pemilik.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="id_hewan">Pilih Hewan</label>
            <select name="id_hewan" id="id_hewan" class="form-control" required>
                <option value="">Pilih Hewan</option>
                @foreach($hewan as $h)
                    <option value="{{ $h->id_hewan }}">{{ $h->nama_hewan }} ({{ $h->jenis }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="keluhan">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="tanggal_konsultasi">Tanggal Konsultasi</label>
            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Konsultasi</button>
    </form>
</div>
@endsection
