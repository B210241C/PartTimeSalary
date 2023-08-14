@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Attendance Pending Verify</h1>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
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
        @if($attendances->count() > 0)
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
                            {!! Form::open(['method' => 'POST','route' => ['verifyAttendance', $attendance->id]]) !!}
                            {!! Form::submit('Approve', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">No Attendance Need To Approve</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
