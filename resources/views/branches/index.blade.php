@extends('default')

@section('content')

	<div class="d-flex justify-content-end mb-3"><a href="{{ route('branches.create') }}" class="btn btn-info">Create</a></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>id</th>
				<th>name</th>

				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($branches as $branch)

				<tr>
					<td>{{ $branch->id }}</td>
					<td>{{ $branch->name }}</td>

					<td>
						<div class="d-flex gap-2">
                            <a href="{{ route('branches.edit', [$branch->id]) }}" class="btn btn-primary">Edit</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['branches.destroy', $branch->id]]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
					</td>
				</tr>

			@endforeach
		</tbody>
	</table>

@stop
