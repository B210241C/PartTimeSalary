@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Attendance Pending Verify</h1>
    </div>
    <hr />
    <form action="{{ route('searchAttendances') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search by user or branch" aria-describedby="searchButton">
            <select name="month" class="form-control">
                <option value="">Select Month</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
            <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
        </div>
    </form>

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
        <tr>
            <th>User</th>
            <th>Outlet</th>
            <th>From</th>
            <th>Date</th>
            <th>Status</th>
            <th>Time Range (H)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($attendances->count() > 0)
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->uname }}</td>
                    <td>{{ $attendance->bname }}</td>
                    <td>
                        @php
                            $timeIn = new DateTime($attendance->timein);
                            $timeOut = new DateTime($attendance->timeout);
                            $formattedTimeIn = $timeIn->format('g.iA');
                            $formattedTimeOut = $timeOut->format('g.iA');
                            echo $formattedTimeIn . ' to ' . $formattedTimeOut;
                        @endphp
                    </td>
                    <td>{{ date('d F', strtotime($attendance->date)) }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>
                        @php
                            $timeInterval = $timeOut->diff($timeIn);
                            $hours = $timeInterval->h;
                            $minutes = $timeInterval->i;
                            $decimalHours = $hours + ($minutes / 60);
                            echo number_format($decimalHours, 1);
                        @endphp
                    </td>
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
                <td class="text-center" colspan="6">No Result</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
