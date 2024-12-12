@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Doctor Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Consultations</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-primary">View Consultations</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">Diagnoses</div>
                <div class="card-body">
                    <a href="#" class="btn btn-sm btn-success">View Diagnoses</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
