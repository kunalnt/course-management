@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Course: {{ $course->title }}</h2>

    <p><strong>Description:</strong> {{ $course->description ?? 'N/A' }}</p>
    <p>
        <strong>Max Seats:</strong> {{ $course->max_seats }} |
        <strong>Enrolled:</strong> {{ $course->enrollments->count() }} |
        <strong>Remaining:</strong> {{ $course->max_seats - $course->enrollments->count() }}
    </p>

    <h4 class="mt-4">Sections</h4>
    @if($course->sections->count())
        @include('components.section_seats', ['course' => $course])
    @else
        <p>No sections created for this course.</p>
    @endif
</div>
@endsection
