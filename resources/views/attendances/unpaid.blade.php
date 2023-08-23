@extends('layouts.userApp')

@section('contents')
    <hr />
    {{--    ph--}}
    <h1 class="mb-0">Attendance Unpaid</h1>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Outlet</th>
            <th>From</th>
            <th>Date</th>
            <th>Duration(H)</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totalDurationMinutes = 0;
            $totalSalary = 0;
        @endphp
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
                        @php
                            $timeDifference = $timeOut->diff($timeIn);
                            $totalMinutes = ($timeDifference->h * 60) + $timeDifference->i;
                            echo number_format($totalMinutes / 60, 2);
                            $totalDurationMinutes += $totalMinutes;

                            $attendanceSalary = $totalMinutes / 60 * Auth::user()->salary;
                            $totalSalary += $attendanceSalary;
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total Hours:</strong></td>
                <td>{{ number_format($totalDurationMinutes / 60, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Amount(RM)</strong></td>
                <td>{{ number_format($totalSalary, 2) }}</td>
            </tr>
        @else
            <tr>
                <td class="text-center" colspan="6">No Result</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
