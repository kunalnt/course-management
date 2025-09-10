@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Available Courses</h2>

    @foreach($courses as $course)
        @php
            $filled = $course->enrollments->count();
            $remaining = $course->seat_limit - $filled;
        @endphp

        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><strong>{{ $course->title }}</strong></span>
                <form action="{{ route('enroll.course',$course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light" @if($remaining<=0) disabled @endif>
                        Enroll in Course
                    </button>
                </form>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $course->description ?? 'N/A' }}</p>
                <p>

                    Max Seats: {{ $course->seat_limit }} |
                    Enrolled: {{ $filled }} |
                    Remaining: {{ $remaining }}
                </p>

                <h5 class="mt-3">Sections</h5>
                <div class="row">
                    @foreach($course->sections as $section)
                        <div class="col-md-6">
                            @include('components.student_section_seats',['section'=>$section])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
