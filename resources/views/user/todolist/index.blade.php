@extends('user.layouts.master')
@section('extra-css')
    <style>
        .add-btn {
            color: blue;
            font-size: 25px;
            transition: color 0.3s ease;
        }

        .add-btn:hover {
            color: green;
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
        <h1>To-do Lists</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">To-do Lists</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="d-flex justify-content-end">
        <a href="{{ route('todolist.history') }}" class="btn-theme"> <i class="bi bi-list-columns-reverse me-1"></i>
            History</a>
    </div>

    <section id="todolist-dashboard" class="section py-3"></section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var types = @json($types);

            todolistData();

            function todolistData() {
                $.ajax({
                    url: '/todolist/data',
                    type: 'GET',
                    success: function(res) {
                        $('#todolist-dashboard').html(res);
                        /* preloading */
                        $('.preloading').css('display', 'none');
                    }
                })
            }

            $(document).on('click', '.todolist-check', function(e) {
                e.preventDefault();

                $(this).toggleClass('bg-green');
                $(this).next().toggleClass('strike-none');

                var id = $(this).data('id');
                $.ajax({
                    url: `/todolist/${id}`,
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        'status': ''
                    },
                    success: function(res) {
                        todolistData();
                    }
                })
            })

            $(document).on('click', '.add-btn', function(e) {
                e.preventDefault();

                var todolist_type_options = '';
                types.forEach(type => {
                    todolist_type_options += `<option value="${type.id}">${type.name}</option>`;
                })

                // console.log(types);

                Swal.fire({
                    title: `Add Task`,
                    html: `
                        <form id="add-todolist-form">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Title</span>
                                <input type="text" name="title" class="form-control"/>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="rate-your-day">Type</label>
                                <select name="todolist_type_id" class="form-select" id="rate-your-day">
                                    <option value="" selected disabled>Choose one</option>
                                    ${todolist_type_options}
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $("#add-todolist-form").serialize();
                        // console.log(formData);

                        $.ajax({
                            url: '/todolist',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            success: function(res) {
                                todolistData();
                                toastr.success('New task created.')
                            },
                            error: function(res) {
                                if (res.responseJSON.errors.title) {
                                    toastr.warning(res.responseJSON.errors.title);
                                }
                                if (res.responseJSON.errors.todolist_type_id) {
                                    toastr.warning(res.responseJSON.errors
                                        .todolist_type_id);
                                }
                            }
                        })
                    }

                })
            })

            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();

                var todolist = JSON.parse(atob($(this).data('todolist')));
                console.log(todolist);
                var todolist_type_options = '';
                types.forEach(type => {
                    todolist_type_options +=
                        `<option value="${type.id}" ${todolist.todolist_type_id == type.id ? 'selected' : ''}>${type.name}</option>`;
                })

                // console.log(types);

                Swal.fire({
                    title: `Add Task`,
                    html: `
                        <form id="edit-todolist-form">
                            <input type="hidden" name="status" value="${todolist.status}"/>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Title</span>
                                <input type="text" name="title" class="form-control" value="${todolist.title}"/>
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="rate-your-day">Type</label>
                                <select name="todolist_type_id" class="form-select" id="rate-your-day">
                                    <option value="" selected disabled>Choose one</option>
                                    ${todolist_type_options}
                                </select>
                            </div>
                        </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Confirm',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $("#edit-todolist-form").serialize();
                        // console.log(formData);

                        $.ajax({
                            url: `/todolist/${todolist.id}`,
                            type: 'PUT',
                            dataType: 'json',
                            data: formData,
                            success: function(res) {
                                console.log(res)
                                todolistData();
                                toastr.info('Task updated.')
                            },
                            error: function(res) {
                                if (res.responseJSON.errors.title) {
                                    toastr.warning(res.responseJSON.errors.title);
                                }
                                if (res.responseJSON.errors.todolist_type_id) {
                                    toastr.warning(res.responseJSON.errors
                                        .todolist_type_id);
                                }
                            }
                        })
                    }

                })
            })

            $(document).on('click', '.delete-btn', function(e) {
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
                            url: `/todolist/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                todolistData();
                                toastr.info('Task deleted.')
                            }
                        })
                    }
                })
            })

        })
    </script>
@endsection
