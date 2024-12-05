    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Edit Doctor</h1>
        <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.dokter.form')
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
        </form>        
    </div>
    @endsection
