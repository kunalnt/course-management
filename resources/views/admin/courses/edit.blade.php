@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Edit Course</div>
    <div class="card-body">
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="title" value="{{ $course->title }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Max Seats</label>
                <input type="number" name="seat_limit" value="{{ $course->seat_limit }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
