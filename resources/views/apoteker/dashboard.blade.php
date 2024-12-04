@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pharmacist Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Medications</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-primary">Manage Medications</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">Prescriptions</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-success">View Prescriptions</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-white">Transactions</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-warning">Manage Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
