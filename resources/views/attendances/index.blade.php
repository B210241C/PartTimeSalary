@extends('layouts.userApp')

@section('contents')
    <hr />
    {{--    ph--}}
    <h1 class="mb-0">Attendance Pending</h1>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Outlet</th>
            <th>Duration</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($attendances->count() > 0)
        @foreach($attendances as $attendance)

            <tr>
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

                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('attendances.edit', [$attendance->id, $attendance->timein, $attendance->timeout, $attendance->date]) }}" class="btn btn-primary">Edit</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['attendances.destroy', $attendance->id]]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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
