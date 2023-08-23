@extends('layouts.userApp')

@section('title', 'Edit Attendance')

@section('contents')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <hr />
    {{ Form::model($datas, array('route' => array('attendances.update', $datas->id), 'method' => 'PUT')) }}
    <div class="form-group">
        <label for="branch" class="col-sm-3 control-label">Branch</label>
        <div>
            <select name="branchid">
                @foreach($data as $branch)
                    <option value="{{$branch->id}}" @selected($datas->branchid)>{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="timein" class="col-sm-3 control-label">Time In</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timein" name="timein" required value="{{$datas['timein']}}">
            @error('timein')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="timeout" class="col-sm-3 control-label">Time Out</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timeout" name="timeout" required value="{{$datas['timeout']}}">
            @error('timeout')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="date" class="col-sm-3 control-label">Date</label>
        <div class="bootstrap-datepicker">
            <input type="date" class="form-control datepicker" id="date" name="date" required value="{{$datas['date']}}">
            @error('date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection
