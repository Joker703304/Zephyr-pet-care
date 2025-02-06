@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Hewan</h1>

    <form action="{{ route('pemilik-hewan.hewan.update', $hewan->id_hewan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_hewan">Nama Hewan</label>
            <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
        </div>

        <div class="form-group">
            <label for="jenis_id">Jenis Hewan</label>
            <select name="jenis_id" id="jenis_id" class="form-control" required>
                @foreach($jenisHewan as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('jenis_id', $hewan->jenis_id) == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="jantan" {{ old('jenkel', $hewan->jenkel) == 'jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="betina" {{ old('jenkel', $hewan->jenkel) == 'betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        <div class="form-group">
            <label for="umur">Umur (Bulan)</label>
            <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur', $hewan->umur) }}">
        </div>

        <div class="form-group">
            <label for="berat">Berat (Gram)</label>
            <input type="number" name="berat" id="berat" class="form-control" value="{{ old('berat', $hewan->berat) }}">
        </div>

        <div class="form-group">
            <label for="foto">Foto Hewan</label>
            <input type="file" name="foto" id="foto" class="form-control">
            @if($hewan->foto)
                <img src="{{ asset('storage/' . $hewan->foto) }}" alt="Foto Hewan" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Hewan</button>
        <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection