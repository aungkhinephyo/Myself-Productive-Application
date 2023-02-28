@extends('user.layouts.master')
@section('extra-css')
    <style>
        .input-group-text {
            display: inline-block;
            min-width: 100px;
        }

        /* sortable js */
        .sortable-ghost {
            background: #eee !important;
            border: 2px dashed #aaa;
        }
    </style>
@endsection
@section('preloading')
    <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="100px" />
    </div>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>My Project</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Projects</a></li>
                <li class="breadcrumb-item active">My Project</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card h-100 mb-0">
                    <div class="card-body py-3">
                        <h5 class="fw-bolder mb-2">{{ $project->title }}</h5>
                        <p class="text-muted mb-1 fs-6">Start Date - {{ $project->start_date }}</p>
                        <p class="text-muted mb-4 fs-6">Deadline - {{ $project->deadline }}</p>
                        <p class="mb-0 fs-6 mb-0">{{ $project->description }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card mb-3">
                    <div class="card-body py-3" style="min-height: 103px;">
                        <div id="images" class="preview-img">
                            @forelse ($project->images ?? [] as $image)
                                <img src="{{ $project->img_path() . '/' . $image }}" alt="project-img">
                            @empty
                                <p class="mb-1"><i class="bi bi-image fs-3"></i></p>
                                <span class="fw-bold">No image added.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card mb-0">
                    <div class="card-body py-3" style="min-height: 103px;">
                        <div class="d-flex flex-wrap">
                            @forelse ($project->files ?? [] as $file)
                                <a href="{{ $project->file_path() . '/' . $file }}" target="_blank" class="pdf-thumbnail"
                                    title="{{ $file }}}">
                                    <i class="bi bi-filetype-pdf"></i>
                                </a>
                            @empty
                                <div>
                                    <p class="mb-1"><i class="bi bi-filetype-pdf fs-3"></i></p>
                                    <span class="fw-bold">No file added.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="task-data" class="card-body py-4 mb-0"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {

            /* preloading */
            setTimeout(() => {
                $('.preloading').css('display', 'none')
            }, 2500);

            @if ($project->images)
                const gallery = new Viewer(document.getElementById('images'));
            @endif

            var project_id = {{ $project->id }};

            taskData();

            function taskData() {
                $.ajax({
                    url: `/task/data?project_id=${project_id}`,
                    type: 'GET',
                    success: function(res) {
                        $('#task-data').html(res);
                        activeSortable();
                        /* preloading */
                        $('.preloading').css('display', 'none')
                    },
                })
            }

            function activeSortable() {
                var pendingTaskboard = document.getElementById('pending-taskboard');
                var inProgressTaskboard = document.getElementById('in-progress-taskboard');
                var completeTaskboard = document.getElementById('complete-taskboard');

                Sortable.create(pendingTaskboard, {
                    group: 'taskboard',
                    draggable: ".task-item",
                    ghostClass: "sortable-ghost",
                    animation: 200,
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('pending-taskboard', order.join(','));
                        }
                    },
                    onSort: function(evt) {
                        setTimeout(function() {
                            var pending_taskboard = localStorage.getItem(
                                'pending-taskboard');

                            $.ajax({
                                url: '/task/draggable',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    pending_taskboard: pending_taskboard
                                },
                                success: function(res) {
                                    console.log(res.message)
                                }
                            })
                        }, 1000);
                    },
                });

                Sortable.create(inProgressTaskboard, {
                    group: 'taskboard',
                    draggable: ".task-item",
                    ghostClass: "sortable-ghost",
                    animation: 200,
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('in-progress-taskboard', order.join(','));
                        }
                    },
                    onSort: function(evt) {
                        setTimeout(function() {
                            var in_progress_taskboard = localStorage.getItem(
                                'in-progress-taskboard');

                            $.ajax({
                                url: '/task/draggable',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    in_progress_taskboard: in_progress_taskboard
                                },
                                success: function(res) {
                                    console.log(res.message)
                                }
                            })
                        }, 1000);
                    },
                });

                Sortable.create(completeTaskboard, {
                    group: 'taskboard',
                    draggable: ".task-item",
                    ghostClass: "sortable-ghost",
                    animation: 200,
                    store: {
                        set: function(sortable) {
                            var order = sortable.toArray();
                            localStorage.setItem('complete-taskboard', order.join(','));
                        }
                    },
                    onSort: function(evt) {
                        setTimeout(function() {
                            var complete_taskboard = localStorage.getItem(
                                'complete-taskboard');

                            $.ajax({
                                url: '/task/draggable',
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    complete_taskboard: complete_taskboard
                                },
                                success: function(res) {
                                    console.log(res.message)
                                }
                            })
                        }, 1000);
                    },
                });
            }

            $(document).on('click', '#add-pending-task-btn', function(e) {
                e.preventDefault();
                addTask('Pending', 'pending');
            })
            $(document).on('click', '#add-in-progress-task-btn', function(e) {
                e.preventDefault();
                addTask('In Progress', 'in_progress');
            })
            $(document).on('click', '#add-complete-task-btn', function(e) {
                e.preventDefault();
                addTask('Complete', 'complete');
            })

            function addTask(name, status) {
                Swal.fire({
                    title: `Add New ${name} Task`,
                    html: `
                        <form id="add-task-form">
                            <input type="hidden" name="project_id" value="${project_id}"/>
                            <input type="hidden" name="status" value="${status}"/>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Title</span>
                                <input type="text" name="title" class="form-control"/>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Start Date</span>
                                <input type="text" name="start_date" class="form-control datepicker" />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Deadline</span>
                                <input type="text" name="deadline" class="form-control datepicker" />
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="rate-your-day">Priority</label>
                                <select name="priority" class="form-select" id="rate-your-day">
                                    <option value="" selected disabled>Choose one</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $("#add-task-form").serialize();
                        // console.log(formData);

                        $.ajax({
                            url: '/task',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            success: function(res) {
                                taskData();
                            },
                            error: function(res) {
                                if (res.responseJSON.errors.title) {
                                    toastr.warning(res.responseJSON.errors.title);
                                }
                                if (res.responseJSON.errors.priority) {
                                    toastr.warning(res.responseJSON.errors.priority);
                                }
                            }
                        })
                    }

                })

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "locale": {
                        "format": "YYYY-MM-DD"
                    },
                });
            }

            $(document).on('click', '.edit-task-btn', function(e) {
                e.preventDefault();
                var task = JSON.parse(atob($(this).data('task')));
                console.log(task);

                Swal.fire({
                    title: `Add New ${name} Task`,
                    html: `
                        <form id="edit-task-form">
                            <input type="hidden" name="status" value="${task.status}"/>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Title</span>
                                <input type="text" name="title" class="form-control" value="${task.title}"/>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Start Date</span>
                                <input type="text" name="start_date" class="form-control datepicker" value="${task.start_date}" />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Deadline</span>
                                <input type="text" name="deadline" class="form-control datepicker" value="${task.deadline}"/>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="rate-your-day">Priority</label>
                                <select name="priority" class="form-select" id="rate-your-day">
                                    <option value="" disabled>Choose one</option>
                                    <option value="high" ${task.priority === 'high' ? 'selected' : ''}>High</option>
                                    <option value="medium" ${task.priority === 'medium' ? 'selected' : ''}>Medium</option>
                                    <option value="low" ${task.priority === 'low' ? 'selected' : ''}>Low</option>
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $("#edit-task-form").serialize();
                        // console.log(formData);

                        $.ajax({
                            url: `/task/${task.id}`,
                            type: 'PUT',
                            dataType: 'json',
                            data: formData,
                            success: function(res) {
                                taskData();
                            },
                            error: function(res) {
                                if (res.responseJSON.errors.title) {
                                    toastr.warning(res.responseJSON.errors.title);
                                }
                                if (res.responseJSON.errors.priority) {
                                    toastr.warning(res.responseJSON.errors.priority);
                                }
                            }
                        })
                    }

                })

                $('.datepicker').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "autoApply": true,
                    "locale": {
                        "format": "YYYY-MM-DD"
                    },
                });
            })

            $(document).on('click', '.delete-task-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/task/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                taskData();
                            }
                        })
                    }
                })
            })

        })
    </script>
@endsection
