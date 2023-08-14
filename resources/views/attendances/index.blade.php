@extends('layouts.userApp')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Attendance List</h1>
        <a href="{{ route('attendances.create') }}" class="btn btn-primary">Add Attendance</a>
    </div>
    <hr />
    <label for="search" class="block text-sm mt-4 ">
        <h3 class="text-gray-700 dark:text-gray-400">Search:</h3>
        <input type="text" id="search" name="search"
               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
               placeholder="Type to Search" required />
    </label>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
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
                <td>{{ $attendance->bname }}</td>
                <td>{{ $attendance->timein }}</td>
                <td>{{ $attendance->timeout }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->status }}</td>
                <td>{{ $attendance->duration }}</td>

                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('attendances.edit', [$attendance->id,$attendance->timein,$attendance->timeout,$attendance->date]) }}" class="btn btn-primary">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['attendances.destroy', $attendance->id]]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
@endsection
