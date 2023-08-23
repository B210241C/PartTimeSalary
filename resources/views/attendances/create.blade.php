@extends('layouts.userApp')

@section('contents')
    <h1 class="mb-0">Add Attendance</h1>
    <hr />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(['route' => 'attendances.store']) !!}


    <div class="mb-3" hidden="true">
        {{ Form::label('userid', 'Userid', ['class'=>'form-label']) }}
        {{ Form::text('userid', 1, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        <label for="branch" class="col-sm-3 control-label">Branch</label>
        <div>
            <select name="branchid">
                @foreach($data as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="timein" class="col-sm-3 control-label">Time In</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timein" name="timein" required>
        </div>
        @error('timein')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="timeout" class="col-sm-3 control-label">Time Out</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timeout" name="timeout" required>
        </div>
        @error('timeout')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="date" class="col-sm-3 control-label">Date</label>
        <div class="bootstrap-datepicker">
            <input type="date" class="form-control datepicker" id="date" name="date" required>
        </div>
    </div>

    {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

    {{ Form::close() }}

@endsection
