@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Daftar Hewan</h1>
    <a href="{{ route('admin.hewan.show-jenis') }}" class="btn btn-primary mb-3">Lihat Jenis Hewan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-3">
        <div class="col-md-4">
            <form action="{{ route('admin.hewan.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Hewan atau Pemilik" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <div class="col-md-3">
            <form action="{{ route('admin.hewan.index') }}" method="GET">
                <select name="jenis" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Jenis Hewan --</option>
                    @foreach($jenisHewan as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admin.hewan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>

    <div class="card shadow rounded">
        <div class="card-header">
            <h5 class="mb-0">Data Hewan</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'pemilik.nama', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Pemilik
                                @if(request('sort') == 'pemilik.nama')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'nama_hewan', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Nama Hewan
                                @if(request('sort') == 'nama_hewan')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'jenis.nama_jenis', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Jenis
                                @if(request('sort') == 'jenis.nama_jenis')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'jenkel', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Jenis Kelamin
                                @if(request('sort') == 'jenkel')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'umur', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Umur (Bulan)
                                @if(request('sort') == 'umur')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.hewan.index', ['sort' => 'berat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Berat (Gram)
                                @if(request('sort') == 'berat')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hewan as $item)
                    <tr>
                        <td>{{ $item->pemilik->nama ?? '-' }}</td>
                        <td>{{ $item->nama_hewan }}</td>
                        <td>{{ $item->jenis->nama_jenis ?? 'Jenis tidak ditemukan' }}</td>
                        <td>{{ $item->jenkel }}</td>
                        <td>{{ $item->umur }}</td>
                        <td>{{ number_format($item->berat, 0, ',', '.') }}</td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" width="50">
                            @else
                                Tidak ada
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="d-flex justify-content-between align-items-center mt-3">
        <span>Halaman {{ $hewan->currentPage() }} dari {{ $hewan->lastPage() }}</span>
        <div>
            {{ $hewan->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
