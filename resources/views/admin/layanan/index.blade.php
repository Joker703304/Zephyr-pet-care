@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Daftar Layanan</h1>
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary mb-3">Tambah Layanan</a>

        <div class="row mb-3">
            <div class="col-md-4">
                <form action="{{ route('admin.layanan.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama Layanan atau Deskripsi" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

            <div class="col-md-2">
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('admin.layanan.index', ['sort' => 'nama_layanan', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                            Nama Layanan
                            @if(request('sort') == 'nama_layanan')
                                {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('admin.layanan.index', ['sort' => 'deskripsi', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                            Deskripsi
                            @if(request('sort') == 'deskripsi')
                                {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('admin.layanan.index', ['sort' => 'harga', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                            Harga
                            @if(request('sort') == 'harga')
                                {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                            @endif
                        </a>
                    </th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanans as $layanan)
                    <tr>
                        <td>{{ $layanan->nama_layanan }}</td>
                        <td>{{ $layanan->deskripsi }}</td>
                        <td>{{ number_format($layanan->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.layanan.edit', $layanan->id_layanan) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.layanan.destroy', $layanan->id_layanan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus layanan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span>Halaman {{ $layanans->currentPage() }} dari {{ $layanans->lastPage() }}</span>
            <div>
                {{ $layanans->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
