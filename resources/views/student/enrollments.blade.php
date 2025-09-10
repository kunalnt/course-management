@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Enrollments</h2>

    @if($enrollments->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Enrolled At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollments as $enroll)
                    <tr>
                        <td>{{ $enroll->course->title }}</td>
                        <td>{{ $enroll->section->name }}</td>
                        <td>{{ $enroll->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You are not enrolled in any course yet.</p>
    @endif
</div>
@endsection
