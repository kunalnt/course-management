<div class="card mb-3 shadow-sm">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $section->name }}</h5>
        <span class="badge bg-light text-dark">
            Seats: {{ $section->enrollments->count() }} / {{ $section->max_seats }}
        </span>
    </div>
    <div class="card-body">
        @php
            $filled = $section->enrollments->count();
            $available = $section->max_seats - $filled;
        @endphp

        <div class="d-flex flex-wrap gap-1 mb-2">
            @for($i=0;$i<$filled;$i++)
                <span class="badge bg-danger"><i class="bi bi-person-fill"></i></span>
            @endfor
            @for($i=0;$i<$available;$i++)
                <span class="badge bg-success"><i class="bi bi-person"></i></span>
            @endfor
        </div>

        @auth
            @if(!$section->enrollments->contains('user_id', auth()->id()) && $available>0)
                <form action="{{ route('enroll.section',$section->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary w-100">Enroll in this Section</button>
                </form>
            @elseif($section->enrollments->contains('user_id', auth()->id()))
                <div class="alert alert-success p-2 text-center mb-0">Already enrolled</div>
            @else
                <div class="alert alert-warning p-2 text-center mb-0">No seats available</div>
            @endif
        @endauth
    </div>
</div>
