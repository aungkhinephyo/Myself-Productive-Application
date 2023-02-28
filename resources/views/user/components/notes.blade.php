<div class="row">
    {{-- limit 171 normal text --}}
    {{-- limit 228 small text --}}
    @foreach ($notes as $note)
        <div class="col-xl-3 note-container mb-4">
            <div class="card mb-0 note">
                <div class="card-body p-3">
                    <a href="{{ route('note.show', $note->id) }}" class="d-block w-100 text-dark">
                        <h6 class="fw-bold text-truncate">{{ \Stevebauman\Purify\Facades\Purify::clean($note->title) }}
                        </h6>
                        <p class="small mb-0">{!! \Stevebauman\Purify\Facades\Purify::clean(str()->limit($note->content, 200)) !!}</p>
                    </a>
                    <div class="action-container">
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('note.show', $note->id) }}" class="text-primary" title="Read or Edit"><i
                                    class="bi bi-book"></i></a>
                            <a href="javascript:void(0);" class="text-danger delete-btn" title="Delete"
                                data-id="{{ $note->id }}"><i class="bi bi-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
