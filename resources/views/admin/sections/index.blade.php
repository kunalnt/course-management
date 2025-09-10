@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3 align-items-center">
    <div>
        <h3>Sections for: <strong>{{ $course->name }}</strong></h3>
        <p class="mb-0 text-muted">{{ $course->description }}</p>
    </div>

    <div>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary me-2">Back to Courses</a>
        <a href="{{ route('admin.courses.sections.create', $course->id) }}" class="btn btn-primary">+ Add Section</a>
    </div>
</div>

@if($course->sections->isEmpty())
    <div class="alert alert-info">No sections found for this course.</div>
@else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Max Seats</th>
                <th>Remaining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course->sections as $section)
            <tr>
                <td>{{ $section->id }}</td>
                <td>{{ $section->name }}</td>
                <td>{{ $section->max_seats }}</td>
                <td>{{ $section->seatsRemaining() }}</td>
                <td>
                    <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this section?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
