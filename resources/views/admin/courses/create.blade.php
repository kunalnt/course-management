@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Add New Course</div>
    <div class="card-body">
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Max Seats</label>
                <input type="number" name="seat_limit" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Save Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
