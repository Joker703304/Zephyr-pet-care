@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Hewan</h1>

    <form action="{{ route('admin.hewan.update', $hewan->id_hewan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="id_pemilik">Pemilik Hewan</label>
            <select name="id_pemilik" id="id_pemilik" class="form-control" required>
                <option value="">Pilih Pemilik</option>
                @foreach($pemilik as $item)
                    <option value="{{ $item->id_pemilik }}" {{ $item->id_pemilik == $hewan->id_pemilik ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nama_hewan">Nama Hewan</label>
            <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
        </div>

        <div class="form-group">
            <label for="jenis">Jenis Hewan</label>
            <input type="text" name="jenis" id="jenis" class="form-control" value="{{ old('jenis', $hewan->jenis) }}" required>
        </div>

        <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="jantan" {{ $hewan->jenkel == 'jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="betina" {{ $hewan->jenkel == 'betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur', $hewan->umur) }}">
        </div>

        <div class="form-group">
            <label for="berat">Berat</label>
            <input type="number" step="0.01" name="berat" id="berat" class="form-control" value="{{ old('berat', $hewan->berat) }}">
        </div>

        <div class="form-group">
            <label for="foto">Foto Hewan</label>
            <input type="file" name="foto" id="foto" class="form-control">
            @if ($hewan->foto)
                <img src="{{ asset('storage/' . $hewan->foto) }}" alt="Foto Hewan" width="100" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-warning mt-3">Update</button>
    </form>
</div>
@endsection
