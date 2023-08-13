@extends('layouts.app')

@section('title', 'Create Branch')

@section('contents')
    <h1 class="mb-0">Add Branch</h1>
    <hr />
    {!! Form::open(['route' => 'branches.store']) !!}

    <div class="mb-3">
        {{ Form::label('name', 'Name', ['class'=>'form-label']) }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>


    {{ Form::submit('Create', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection
