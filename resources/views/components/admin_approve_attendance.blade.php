<div>

</div>
@extends('default')

@section('content')


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Outlet</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Date</th>
            <th>Status</th>
            <th>Working Hour</th>

            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attendances as $attendance)

            <tr>
                <td>{{ $attendance->id }}</td>
                <td>{{ $attendance->uname }}</td>
                <td>{{ $attendance->bname }}</td>
                <td>{{ $attendance->timein }}</td>
                <td>{{ $attendance->timeout }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->status }}</td>
                <td>{{ $attendance->duration }}</td>

                <td>
                    <div class="d-flex gap-2">
                        {!! Form::open(['method' => 'APPROVE','route' => ['attendances.approve', $attendance->id]]) !!}
                        {!! Form::submit('Approve', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

@stop
