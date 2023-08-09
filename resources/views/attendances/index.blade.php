@extends('default')

@section('content')

	<div class="d-flex justify-content-end mb-3"><a href="{{ route('attendances.create') }}" class="btn btn-info">Create</a></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>id</th>
				<th>timein</th>
				<th>timeout</th>
				<th>date</th>

				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($attendances as $attendance)

				<tr>
					<td>{{ $attendance->id }}</td>
					<td>{{ $attendance->timein }}</td>
					<td>{{ $attendance->timeout }}</td>
					<td>{{ $attendance->date }}</td>

					<td>
						<div class="d-flex gap-2">
                            <a href="{{ route('attendances.show', [$attendance->id]) }}" class="btn btn-info">Show</a>
                            <a href="{{ route('attendances.edit', [$attendance->id]) }}" class="btn btn-primary">Edit</a>
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
