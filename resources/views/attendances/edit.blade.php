@extends('default')

@section('content')

	@if($errors->any())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				{{ $error }} <br>
			@endforeach
		</div>
	@endif

	{{ Form::model($attendance, array('route' => array('attendances.update', $attendance->id), 'method' => 'PUT')) }}

    <div class="mb-3" hidden="true">
        {{ Form::label('userid', 'Userid', ['class'=>'form-label']) }}
        {{ Form::text('userid', 1, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        <label for="timein" class="col-sm-3 control-label">Time In</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timein" name="timein" required>
        </div>
    </div>

    <div class="form-group">
        <label for="timeout" class="col-sm-3 control-label">Time Out</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timeout" name="timeout" required>
        </div>
    </div>

    <div class="form-group">
        <label for="date" class="col-sm-3 control-label">Date</label>
        <div class="bootstrap-datepicker">
            <input type="date" class="form-control datepicker" id="date" name="date" required>
        </div>
    </div>

		{{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
@stop
