<div class="row">
    <h5 class="fw-bolder">Tasks</h5>

    <div class="col-md-4 mb-md-0 mb-3">
        <div class="card">
            <div class="card-header bg-warning text-white fw-bold d-flex justify-content-between">
                <div>
                    <i class="bi bi-list-task"></i> Pending
                </div>
                <a href="#" id="add-pending-task-btn" title="Add Task"><i
                        class="bi bi-plus-square-fill text-dark fs-5"></i></a>
            </div>
            <div class="card-body px-2 py-3 bg-warning-light" style="min-height: 100px;">

                <div id="pending-taskboard">
                    @foreach (collect($tasks)->where('status', 'pending')->sortBy('serial_number') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="fw-bold">{{ $task->title }}</h6>
                                <div class="task-item-actions">
                                    <a href="#" class="text-primary edit-task-btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="text-danger delete-task-btn"
                                        data-id="{{ $task->id }}"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="small mb-3">
                                    <span class="me-2"><i class="bi bi-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</span>
                                    <span><i class="bi bi-hourglass-top"></i>
                                        {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</span>
                                </p>
                                <div class="d-flex justify-content-between">
                                    @if ($task->priority === 'high')
                                        <span class="badge rounded-pill bg-danger">High</span>
                                    @elseif($task->priority === 'medium')
                                        <span class="badge rounded-pill bg-info">Medium</span>
                                    @elseif($task->priority === 'low')
                                        <span class="badge rounded-pill bg-dark">Low</span>
                                    @endif
                                    <small><em>{{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</em></small>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <div class="d-grid">
                    <a href="#" id="add-pending-task-btn" class="btn btn-dark mt-3"><i
                            class="bi bi-plus-square-dotted me-2"></i> Add
                        Task</a>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-md-0 mb-3">
        <div class="card">
            <div class="card-header bg-info text-white fw-bold d-flex justify-content-between">
                <div>
                    <i class="bi bi-list-task"></i> In Progress
                </div>
                <a href="#" id="add-in-progress-task-btn" title="Add Task"><i
                        class="bi bi-plus-square-fill text-dark fs-5"></i></a>
            </div>
            <div class="card-body px-2 py-3 bg-info-light" style="min-height: 100px;">

                <div id="in-progress-taskboard">
                    @foreach (collect($tasks)->where('status', 'in_progress')->sortBy('serial_number') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="fw-bold">{{ $task->title }}</h6>
                                <div class="task-item-actions">
                                    <a href="#" class="text-primary edit-task-btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="text-danger delete-task-btn"
                                        data-id="{{ $task->id }}"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="small mb-3">
                                    <span class="me-2"><i class="bi bi-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</span>
                                    <span><i class="bi bi-hourglass-top"></i>
                                        {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</span>
                                </p>
                                <div class="d-flex justify-content-between">
                                    @if ($task->priority === 'high')
                                        <span class="badge rounded-pill bg-danger">High</span>
                                    @elseif($task->priority === 'medium')
                                        <span class="badge rounded-pill bg-info">Medium</span>
                                    @elseif($task->priority === 'low')
                                        <span class="badge rounded-pill bg-dark">Low</span>
                                    @endif
                                    <small><em>{{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</em></small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-md-0 mb-3">
        <div class="card">
            <div class="card-header text-white fw-bold d-flex justify-content-between"
                style="background-color: #01ee01;">
                <div>
                    <i class="bi bi-list-task"></i> Complete
                </div>
                <a href="#" id="add-complete-task-btn" title="Add Task"><i
                        class="bi bi-plus-square-fill text-dark fs-5"></i></a>
            </div>
            <div class="card-body px-2 py-3 bg-success-light" style="min-height: 100px;">

                <div id="complete-taskboard">
                    @foreach (collect($tasks)->where('status', 'complete')->sortBy('serial_number') as $task)
                        <div class="task-item" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="fw-bold">{{ $task->title }}</h6>
                                <div class="task-item-actions">
                                    <a href="#" class="text-primary edit-task-btn"
                                        data-task="{{ base64_encode(json_encode($task)) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="text-danger delete-task-btn"
                                        data-id="{{ $task->id }}"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="small mb-3">
                                    <span class="me-2"><i class="bi bi-clock"></i>
                                        {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</span>
                                    <span><i class="bi bi-hourglass-top"></i>
                                        {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</span>
                                </p>
                                <div class="d-flex justify-content-between">
                                    @if ($task->priority === 'high')
                                        <span class="badge rounded-pill bg-danger">High</span>
                                    @elseif($task->priority === 'medium')
                                        <span class="badge rounded-pill bg-info">Medium</span>
                                    @elseif($task->priority === 'low')
                                        <span class="badge rounded-pill bg-dark">Low</span>
                                    @endif
                                    <small><em>{{ Carbon\Carbon::parse($task->deadline)->diffForHumans() }}</em></small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
