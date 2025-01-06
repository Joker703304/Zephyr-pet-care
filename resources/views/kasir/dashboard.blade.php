@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Doctor Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">List Daftar Ulang</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-primary">View List</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">Transaksi</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-success">View transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
