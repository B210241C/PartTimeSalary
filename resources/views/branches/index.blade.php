@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Branch List</h1>
        <a href="{{ route('branches.create') }}" class="btn btn-primary">Add Branch</a>
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
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if($branches->count() > 0)
            @foreach($branches as $branch)
                <tr>
                    <td class="align-middle">{{ $branch->id }}</td>
                    <td class="align-middle">{{ $branch->name }}</td>
                    <td class="align-middle">
                        <div class="btn-toolbar">
                            <a href="{{ route('branches.edit', [$branch->id]) }}" class="btn btn-primary">Edit</a>
                            <div></div>
                            {!! Form::open(['method' => 'DELETE','route' => ['branches.destroy', $branch->id],'onsubmit'=>"return confirm('Delete?')"]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger m-0']) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
          @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">Branch not found</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
