@extends('layouts.app')

@section('style-head')
<link rel="stylesheet" href="{{ asset('Admin-Lte/plugins/toastr/toastr.min.css') }}">


@endsection


<style>
    .container {
        height: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .alert{
        width: inherit;
    }

    .card {
        /* width: 200px !important; */
        background-color: #454D55 !important;
        color: #FFFF;
    }

</style>
@section('content')
<div class="container">

    <div class="row justify-content-center mt-2">
        <div class="card">
            <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <b>Opps!</b> {{session('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/img/bali-tv.png') }}" alt="Logo Bali TV" width="150" height="150">

            </div>
            <form method="POST" action="{{ route('auth') }}">
                @csrf

                <div class="row mb-3 align-items-center">
                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                    <div class="col-md-8">
                        <input id="username" type="text" class="form form-control form-control-sm rounded-0" name="username" value="{{ old('username') }}"
                            required autocomplete="username" autofocus>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form form-control form-control-sm rounded-0" name="password" required
                            autocomplete="current-password">
                    </div>
                </div>


                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4 float-right">
                        <button type="submit" class="btn" style="float: right;
                    color: #FFF;
                    background: #343A40;
                    ">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
@endsection

@section('script')
<script src="{{ asset('Admin-Lte/plugins/toastr/toastr.min.js') }}"></script>
@endsection
