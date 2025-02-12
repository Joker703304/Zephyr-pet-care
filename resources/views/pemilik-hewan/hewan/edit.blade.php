@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card untuk Edit Hewan -->
    <div class="card">
        <div class="card-header">
            <h1>Edit Hewan</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('pemilik-hewan.hewan.update', $hewan->id_hewan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Hewan -->
                <div class="form-group mb-3">
                    <label for="nama_hewan">
                        <i class="fas fa-paw"></i> Nama Hewan
                    </label>
                    <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
                </div>

                <!-- Jenis Hewan -->
                <div class="form-group mb-3">
                    <label for="jenis_id">
                        <i class="fas fa-paw"></i> Jenis Hewan
                    </label>
                    <select name="jenis_id" id="jenis_id" class="form-control" required>
                        @foreach($jenisHewan as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenis_id', $hewan->jenis_id) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group mb-3">
                    <label for="jenkel">
                        <i class="fas fa-venus-mars"></i> Jenis Kelamin
                    </label>
                    <select name="jenkel" id="jenkel" class="form-control" required>
                        <option value="jantan" {{ old('jenkel', $hewan->jenkel) == 'jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="betina" {{ old('jenkel', $hewan->jenkel) == 'betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>

                <!-- Umur -->
                <div class="form-group mb-3">
                    <label for="umur">
                        <i class="fas fa-calendar-alt"></i> Umur (Bulan)
                    </label>
                    <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur', $hewan->umur) }}" min="0" required>
                </div>

                <!-- Berat -->
                <div class="form-group mb-3">
                    <label for="berat">
                        <i class="fas fa-weight-hanging"></i> Berat (Gram)
                    </label>
                    <input type="number" name="berat" id="berat" class="form-control" 
                        value="{{ old('berat', number_format($hewan->berat, 0, '', '')) }}" required>
                </div>

                <!-- Foto Hewan -->
                <div class="form-group mb-3">
                    <label for="foto">
                        <i class="fas fa-camera"></i> Foto Hewan
                    </label>
                    <input type="file" name="foto" id="foto" class="form-control">
                    @if($hewan->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $hewan->foto) }}" alt="Foto Hewan" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex gap-2">
                    <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary mb-3">Update Hewan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection