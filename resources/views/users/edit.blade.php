@extends('layouts.app')


@section('contents')
    <h1 class="mb-0">Edit User</h1>
    <hr />
    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Name</label>
        <div class="mb-3">
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <label for="pnumber" class="col-sm-3 control-label">Phone number</label>
        <div class="mb-3">
            {{ Form::text('pnumber', null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <label for="salary" class="col-sm-3 control-label">Hourly Wages</label>
        <div class="mb-3">
            {{ Form::text('salary', null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <label for="role" class="col-sm-3 control-label">Role</label>
        <div>
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
    </div>

    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection
