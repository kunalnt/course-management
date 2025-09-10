@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Add Section for: <strong>{{ $course->name }}</strong></span>
        <a href="{{ route('admin.courses.sections.index', $course->id) }}" class="btn btn-sm btn-secondary">Back</a>
    </div>

    <div class="card-body">


        <form action="{{ route('admin.courses.sections.store', $course->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Section Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Max Seats</label>
                <input type="number" name="max_seats" class="form-control" value="{{ old('max_seats', 0) }}" min="0" required>
            </div>

            <button type="submit" class="btn btn-success">Create Section</button>
        </form>
    </div>
</div>
@endsection
