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
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Total Hours</th>
            <th>Total Day</th>
            <th>Expected Salary(RM)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($users->count() > 0)
        @foreach($users as $user)

            <tr>
                <td>{{ $user->uid }}</td>
                <td>{{ $user->uname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->pnumber }}</td>
                <td>{{ $user->total_duration/10000 }}</td>
                <td>{{ $user->count }}</td>
                <td>{{ $user->salary*($user->total_duration/10000) }}</td>



                <td>
                    <div class="d-flex gap-2">
                        {!! Form::open(['method' => 'POST','route' => ['checkout', $user->uid]]) !!}
                        {!! Form::submit('Checkout', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>

        @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">Nothing</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
