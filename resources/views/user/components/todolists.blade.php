<div class="row justify-content-center">
    <div class="col-md-6 mb-3">
        <div class="card py-4 mb-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-center fw-bolder mb-0">To-do Lists</h5>
                    <a href="javascript:void(0)" title="Add Task" class="add-btn"><i class="bi bi-plus-circle-fill"></i></a>
                </div>
                <div id="pending" class="my-4">
                    @foreach ($types as $type)
                        <div class="mb-3">
                            <div><span class="text-capitalize text-white small px-4 py-1"
                                    style="background: {{ $type->color }}">{{ $type->name }}</span></div>
                            @forelse (collect($todolists)->where('status', 0)->where('todolist_type_id', $type->id)->sortBy('serial_number') as $todolist)
                                <div class="todolist">
                                    <div class="todolist-info" style="border-left: 4px solid {{ $type->color }}">
                                        <span class="todolist-check" data-id={{ $todolist->id }}><i
                                                class="text-white bi bi-check2"></i></span>
                                        <strike class="strike-none">{{ $todolist->title }}</strike>
                                    </div>
                                    <div class="dropstart">
                                        <a href="javacript:void(0);" class="dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item edit-btn" href="#"
                                                    data-todolist="{{ base64_encode(json_encode($todolist)) }}"><i
                                                        class="bi bi-pencil-square text-primary me-2"></i> Edit</a></li>
                                            <li><a href="#" class="dropdown-item delete-btn"
                                                    data-id={{ $todolist->id }}><i
                                                        class="bi bi-trash text-danger me-2"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="todolist">
                                    <div class="todolist-info" style="height: 54px;">
                                        <strike class="strike-none">No task for this category.</strike>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card py-4 mb-0 h-100">
            <div class="card-body">
                <h5 class="text-center fw-bolder" style="height: 37.5px;line-height:37.5px;">Complete Tasks</h5>
                <div id="complete" class="my-4">
                    @foreach ($types as $type)
                        <div class="mb-3">
                            <div><span class="text-capitalize text-white small px-4 py-1"
                                    style="background: {{ $type->color }}">{{ $type->name }}</span></div>
                            @forelse (collect($todolists)->where('status', 1)->where('todolist_type_id', $type->id)->sortBy('serial_number') as $todolist)
                                <div class="todolist">
                                    <div class="todolist-info" style="border-left: 4px solid {{ $type->color }}">
                                        <span class="todolist-check bg-green" data-id={{ $todolist->id }}><i
                                                class="text-white bi bi-check2"></i></span>
                                        <strike class="">{{ $todolist->title }}</strike>
                                    </div>
                                    <div class="dropstart">
                                        <a href="javacript:void(0);" class="dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item edit-btn" href="#"
                                                    data-todolist="{{ base64_encode(json_encode($todolist)) }}"><i
                                                        class="bi bi-pencil-square text-primary me-2"></i> Edit</a></li>
                                            <li><a class="dropdown-item delete-btn" href="#"
                                                    data-id={{ $todolist->id }}><i
                                                        class="bi bi-trash text-danger me-2"></i>
                                                    Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="todolist">
                                    <div class="todolist-info" style="height: 54px;">
                                        <strike class="strike-none">No complete task for this category.</strike>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
