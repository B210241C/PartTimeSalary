@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Admin List</h1>
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
            <th>No</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($users->count() > 0)
        @foreach($users as $user)

            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->pnumber }}</td>


                <td>
                    <div class="d-flex gap-2">
                        {!! Form::open(['method' => 'POST','route' => ['changeToUser', $user->id]]) !!}
                        {!! Form::submit('Change', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>

        @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">Admin not found</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
