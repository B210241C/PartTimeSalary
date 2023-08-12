@extends('default')

@section('content')

	<div class="d-flex justify-content-end mb-3"><a href="{{ route('attendances.create') }}" class="btn btn-info">Create</a></div>

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

@stop
