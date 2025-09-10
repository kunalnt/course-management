<div class="row">
    @foreach($course->sections as $section)
        @php
            $filled = $section->enrollments->count();
            $available = $section->max_seats - $filled;
        @endphp
        <div class="col-md-6 mb-4">
            <div class="border rounded p-3 h-100">
                <h5 class="mb-3">{{ $section->name }}</h5>
                <p class="mb-1">
                    Seats: <strong>{{ $section->max_seats }}</strong> |
                    Filled: <strong>{{ $filled }}</strong> |
                    Remaining: <strong>{{ $available }}</strong>
                </p>
                <div class="d-flex flex-wrap" style="gap:4px;">
                    @for($i = 1; $i <= $section->max_seats; $i++)
                        @if($i <= $filled)
                            <span class="seat-icon bg-danger"></span>
                        @else
                            <span class="seat-icon bg-success"></span>
                        @endif
                    @endfor
                </div>

                {{-- Admin Manage Buttons --}}
                <div class="mt-2">
                    <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .seat-icon {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 3px;
    }
</style>
