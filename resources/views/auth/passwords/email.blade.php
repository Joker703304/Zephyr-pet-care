@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                         <input type="hidden" name="token" value="{{ request('token') }}">

                        <div class="mb-3">
                            <label for="floatingInput" class="form-label">Phone Number</label>
                            <input name="phone" type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="floatingInput" value="{{ request('phone') }}" >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button class="w-100 btn btn-primary btn-lg mb-3" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
