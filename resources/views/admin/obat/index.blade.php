@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Manajemen Obat</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-3">
        <div class="col-md-4">
            <form action="{{ route('admin.obat.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Obat atau Jenis" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <div class="col-md-3">
            <form action="{{ route('admin.obat.index') }}" method="GET">
                <select name="jenis" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Jenis Obat --</option>
                    @foreach($jenisObats as $jenis)
                        <option value="{{ $jenis->jenis_obat }}" {{ request('jenis') == $jenis->jenis_obat ? 'selected' : '' }}>
                            {{ $jenis->jenis_obat }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-2">
            <a href="{{ route('admin.obat.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>

    <div class="card shadow rounded">
        <div class="card-header">
            <h5 class="mb-0">Data Obat</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('admin.obat.index', ['sort' => 'nama_obat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Nama Obat
                                @if(request('sort') == 'nama_obat')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.obat.index', ['sort' => 'jenis_obat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Jenis Obat
                                @if(request('sort') == 'jenis_obat')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.obat.index', ['sort' => 'stok', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Stok
                                @if(request('sort') == 'stok')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.obat.index', ['sort' => 'harga', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['sort', 'direction'])) }}" class="text-primary">
                                Harga
                                @if(request('sort') == 'harga')
                                    {!! request('direction') == 'asc' ? '▲' : '▼' !!}
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obats as $obat)
                    <tr>
                        <td>{{ $obat->nama_obat }}</td>
                        <td>{{ $obat->jenis_obat }}</td>
                        <td>{{ $obat->stok }}</td>
                        <td>{{ number_format($obat->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="d-flex justify-content-between align-items-center mt-3">
        <span>Halaman {{ $obats->currentPage() }} dari {{ $obats->lastPage() }}</span>
        <div>
            {{ $obats->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
