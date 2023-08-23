@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Attendances for {{ $user->name }}</h1>
    </div>
    <hr />

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date</th>
            <th>Branch</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Duration</th>
            <th>Select</th>
        </tr>
        </thead>
        <tbody>
        @foreach($verifiedAttendances as $attendance)
            <tr>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->branch_name }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->timein)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->timeout)->format('H:i') }}</td>
                <td>
                    @php
                        $timeIn = \Carbon\Carbon::parse($attendance->timein);
                        $timeOut = \Carbon\Carbon::parse($attendance->timeout);
                        $duration = $timeOut->diffInSeconds($timeIn);
                        $formattedDuration = \Carbon\CarbonInterval::seconds($duration)->cascade()->forHumans();
                    @endphp
                    {{ $formattedDuration }}
                </td>
                <td>
                    <input type="checkbox" class="attendance-checkbox" data-duration="{{ $duration }}">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <p>Total Selected Duration: <span id="total-duration">0:00</span></p>
        <p>Total Salary: RM <span id="total-salary">0.00</span></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let totalDuration = 0;
            let userSalary = {{ $userSalary }}; // Pass the user's salary to JavaScript

            // Trigger checkbox change for all checkboxes to calculate initial values
            $('.attendance-checkbox').trigger('change');

            $('.attendance-checkbox').change(function() {
                const duration = parseInt($(this).data('duration'));
                if ($(this).is(':checked')) {
                    totalDuration += duration;
                } else {
                    totalDuration -= duration;
                }

                const hours = Math.floor(totalDuration / 3600);
                const minutes = Math.floor((totalDuration % 3600) / 60);
                const formattedTotalDuration = `${hours}:${minutes.toString().padStart(2, '0')}`;
                $('#total-duration').text(formattedTotalDuration);

                // Calculate and display the total salary
                const totalSalary = (totalDuration / 3600) * userSalary; // Convert duration to hours
                $('#total-salary').text(totalSalary.toFixed(2)); // Display with two decimal places
            });
        });
    </script>

@endsection
