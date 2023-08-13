@extends('layouts.app')

@section('title', 'Edit Branch')

@section('contents')
    <h1 class="mb-0">Edit Branch</h1>
    <hr />
    {{ Form::model($branch, array('route' => array('branches.update', $branch->id), 'method' => 'PUT')) }}

    <div class="mb-3">
        {{ Form::label('name', 'Name', ['class'=>'form-label']) }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection
