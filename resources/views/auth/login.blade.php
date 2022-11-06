@extends('layouts.app')


<style>
   
    .container {
        height: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .card {
        min-width: 40% !important;
        background-color: #454D55 !important;
        color: #FFFF;
    }


</style>
@section('content')
<div class="container">
    <div class="card">
        @if(session('error'))
           {{-- <div class="alert alert-danger">
                   <b>Opps!</b> {{session('error')}}
       </div> --}}
       <div class="alert alert-warning alert-dismissible fade show" role="alert">
           <b>Opps!</b> {{session('error')}}
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
       </div>
       @endif
    <div class="row justify-content-center">

        {{-- <div class="card-header">{{ __('Login') }}
    </div>
    --}}
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('storage/img/bali-tv.png') }}" alt="Logo Bali TV" width="150" height="150">
            
        </div>
        <form method="POST" action="{{ route('auth') }}">
            @csrf

            <div class="row mb-3 align-items-center">
                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                <div class="col-md-7">
                    <input id="username" type="text" class="form"
                        name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                </div>
            </div>

            <div class="row mb-3 align-items-center">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                <div class="col-md-7">
                    <input id="password" type="password" class="form"
                        name="password" required autocomplete="current-password">
                </div>
            </div>


            <div class="row mb-0">
                <div class="col-md-8 offset-md-4 float-right">
                    <button type="submit" class="btn" style="float: right;
                    color: #FFF;
                    background: #343A40;
                    margin-right: 20px;">
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
