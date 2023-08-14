@extends('layouts.userApp')

@section('title', 'Create Branch')

@section('contents')
    <h1 class="mb-0">Add Branch</h1>
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
        </div>
    </div>

    <div class="form-group">
        <label for="timeout" class="col-sm-3 control-label">Time Out</label>
        <div class="bootstrap-timepicker">
            <input type="time" class="form-control timepicker" id="timeout" name="timeout" required value="{{$datas['timeout']}}">
        </div>
    </div>

    <div class="form-group">
        <label for="date" class="col-sm-3 control-label">Date</label>
        <div class="bootstrap-datepicker">
            <input type="date" class="form-control datepicker" id="date" name="date" required value="{{$datas['date']}}">
        </div>
    </div>

    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

@endsection
