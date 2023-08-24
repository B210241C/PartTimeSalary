@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Attendances for {{ $user->name }}</h1>
    </div>
    <hr />

    <form id="mark-as-paid-form" action="{{ route('markMultipleAsPaid') }}" method="POST">        @csrf
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
                            $durationInSeconds = $timeOut->diffInSeconds($timeIn);
                            $decimalDuration = $durationInSeconds / 3600; // Convert seconds to decimal hours
                        @endphp
                        {{ number_format($decimalDuration, 1) }} <!-- Display with one decimal place -->
                    </td>
                    <td>
                        <input
                            type="checkbox"
                            class="attendance-checkbox"
                            data-id="{{ $attendance->id }}"
                            data-duration="{{ $attendance->duration }}"
                            name="attendance_ids[]"
                            value="{{ $attendance->id }}"
                        >
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <p>Total Selected Duration: <span id="total-duration">0:00</span></p>
            <p>Total Salary: RM <span id="total-salary">0.00</span></p>
        </div>

        <button type="submit" class="btn btn-primary" id="mark-as-paid">Mark as Paid</button>
    </form>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let userSalary = {{ $userSalary }}; // Pass the user's salary to JavaScript
            let totalDuration = 0;

            $('.attendance-checkbox').change(function() {
                calculateTotals();
            });

            $('button[type="submit"]').click(function(e) {
                e.preventDefault();

                // Create an array to hold the selected attendance IDs
                const selectedAttendanceIds = [];

                // Loop through checked checkboxes and add their IDs to the array
                $('.attendance-checkbox:checked').each(function() {
                    selectedAttendanceIds.push($(this).data('id'));
                });

                // Perform an AJAX request to mark selected attendances as paid
                // Perform an AJAX request to mark selected attendances as paid
                $.post("{{ route('markMultipleAsPaid') }}", {
                    _token: "{{ csrf_token() }}",
                    attendance_ids: selectedAttendanceIds
                }).done(function(response) {
                    // Handle the response, like showing a success message
                    console.log(response);

                    // Redirect after successful operation
                    window.location.href = "{{ route('checkoutlist') }}"; // Replace with the actual route name
                }).fail(function(error) {
                    // Handle errors, like showing an error message
                    console.error(error);
                });
            });

            function calculateTotals() {
                totalDuration = 0;

                $('.attendance-checkbox:checked').each(function() {
                    const durationString = $(this).data('duration'); // Assuming it's in the format "HH:mm:ss"
                    const durationParts = durationString.split(':');

                    const hours = parseInt(durationParts[0]);
                    const minutes = parseInt(durationParts[1]);
                    const seconds = parseInt(durationParts[2]);

                    const decimalDuration = hours + (minutes / 60) + (seconds / 3600); // Convert to decimal hours
                    totalDuration += decimalDuration;
                });

                $('#total-duration').text(totalDuration.toFixed(1)); // Display with one decimal place

                // Calculate and display the total salary
                const totalSalary = totalDuration * userSalary;
                $('#total-salary').text(totalSalary.toFixed(2)); // Display with two decimal places
            }
        });
    </script>
@endsection

