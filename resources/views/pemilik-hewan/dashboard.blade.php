@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Your Animals</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-primary">View Your Animals</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">Consultations</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-success">View Consultations</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-white">Prescriptions</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-warning">View Prescriptions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
