@extends('layout.main', ['title' => 'Homepage', 'subtitle' => 'Landing'])

@section('content')

<div style="display: flex; justify-content: center;">
    <img src="{{ asset('storage/img/bali-tv.png') }}" style="width: 200px; height: 200px;">

</div>

<div class="container">
    <div class="row justify-content-center">
        {{-- <h1 class="text-center">ASDASDSADASDSA</h1> --}}
        {{-- <h1>ASDASDSADASDSA</h1>
        <h1>ASDASDSADASDSA</h1> --}}
    </div>
</div>

@endsection