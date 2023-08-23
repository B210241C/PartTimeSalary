@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">User List</h1>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Hourly Wages</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($users->count() > 0)
        @foreach($users as $user)

            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->pnumber }}</td>
                <td>{{ $user->salary }}</td>
                <td>{{ $user->role }}</td>


                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('users.edit', [$user->id,$user->salary,$user->role,$user->pnumber]) }}" class="btn btn-primary">Edit</a>
{{--                        {!! Form::open(['method' => 'DELETE','route' => ['attendances.destroy', $attendance->id]]) !!}--}}
{{--                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
{{--                        {!! Form::close() !!}--}}
                    </div>
                </td>
            </tr>

        @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">User not found</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
