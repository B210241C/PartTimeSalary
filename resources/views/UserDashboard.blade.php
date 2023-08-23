@extends('layouts.userApp')


@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">  {{ Auth::user()->name}}</h1>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="mb-0">Hourly Rate :  {{ Auth::user()->salary}}</h2>
    </div>
@endsection
