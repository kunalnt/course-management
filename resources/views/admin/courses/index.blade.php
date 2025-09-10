@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Courses</h2>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add Course</a>
</div>


<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Seats</th>
            <th>Sections</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($courses as $course)
        <tr>
            <td>{{ $course->id }}</td>
            <td>{{ $course->title }}</td>
            <td>{{ $course->seat_limit }}</td>
            <td>
                <!-- {{ $course->sections->count() }}  -->
                <a href="{{ route('admin.courses.sections.index', $course->id) }}" class="btn btn-sm btn-info">Manage Sections</a></td>
            <td>
                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                 <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-sm btn-light">
                    View Details
                </a>
                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No courses found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
