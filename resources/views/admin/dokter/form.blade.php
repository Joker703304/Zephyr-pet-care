<div class="form-group mb-3">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $dokter->nama ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="spesialis">Spesialis</label>
    <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="no_telepon">No Telepon</label>
    <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ old('no_telepon', $dokter->no_telepon ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="hari">Hari Kerja</label>
    <input type="text" name="hari" id="hari" class="form-control" value="{{ old('hari', $dokter->hari ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="jam_mulai">Jam Mulai</label>
    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', $dokter->jam_mulai ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="jam_selesai">Jam Selesai</label>
    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', $dokter->jam_selesai ?? '') }}">
</div>
