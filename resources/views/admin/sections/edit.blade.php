@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Edit Section: <strong>{{ $section->name }}</strong></span>
        <a href="{{ route('admin.courses.sections.index', $section->course->id) }}" class="btn btn-sm btn-secondary">Back</a>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Section Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $section->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Max Seats</label>
                <input type="number" name="max_seats" class="form-control" value="{{ old('max_seats', $section->max_seats) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Seats Remaining</label>
                <input type="text" class="form-control" value="{{ $section->seatsRemaining() }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Update Section</button>
        </form>
    </div>
</div>
@endsection
