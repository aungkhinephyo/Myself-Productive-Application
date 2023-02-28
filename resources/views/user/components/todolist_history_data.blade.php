<div class="card">
    <div class="card-body py-4 mb-0">
        @forelse ($todolists as $date => $todolist)
            <div class="p-3 mb-4 bg-light">
                <h6 class="fw-bolder text-black">
                    <i class="bi bi-calendar-check me-2"></i> 
                    {{ Carbon\Carbon::parse($date)->format('F d') }}
                </h6>
                @foreach ($todolist as $list)
                    <div class="d-flex align-items-center">
                        @if ($list->status === 1)
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                        @else
                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                        @endif

                        <h6 class="mb-0">{{ $list->title }}</h6>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="p-3">
                <p class="mb-0 text-center">No tasks for this range of days.</p>
            </div>
        @endforelse
    </div>
</div>
