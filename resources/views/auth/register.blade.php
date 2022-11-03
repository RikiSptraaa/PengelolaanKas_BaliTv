@extends('layouts.app')

<style>
    .container {
        height: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .card {
        width: 50% !important;
        background-color: #454D55 !important;
        color: #FFFF;
    }
    .form{
        width: 100%;
    }
</style>
@section('content')
<div class="container">
    <div class="d-flex justify-content-center" style="width: 80%">
            <div class="card" >
                {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('storage/img/bali-tv.png') }}" alt="Logo Bali TV" width="150" height="150">
                        
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3 align-items-center">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-7">
                                <input id="name" type="text" class="form" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-7">
                                <input id="username" type="text" class="form @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div>
                                <button type="submit" class="btn" style="float: right;
                                color: #FFF;
                                background: #343A40;
                                ">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    
    </div>
</div>
@endsection
