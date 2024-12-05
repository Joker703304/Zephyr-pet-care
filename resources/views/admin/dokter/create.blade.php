@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Doctor</h1>
    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf
        @include('admin.dokter.form')
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
