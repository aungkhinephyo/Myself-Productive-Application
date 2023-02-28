@extends('user.layouts.master')
@section('extra-css')
    {{-- datatable --}}
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Projects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Projects</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('project.create') }}" class="btn-theme"><i class="bi bi-plus-circle me-2"></i> New
            Project</a>
    </div>

    <div class="card">
        <div class="card-body py-4 mb-0">
            <table id="Datatable" class="table table-hover Datatable" style="width:100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Title</th>
                    <th class="text-center" style="width: 150px">Start Date</th>
                    <th class="text-center" style="width: 150px">Deadline</th>
                    <th class="text-center no-sort no-search" style="width: 150px">Actions</th>
                    <th class="text-center no-search hidden">Created At</th>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
    <script>
        $(document).ready(function() {

            var table = $('.Datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                mark: true,
                ajax: '/project/datatable/ssd',
                columnDefs: [{
                        target: 0,
                        class: "control",
                        orderable: false,
                    },
                    {
                        target: 'no-sort',
                        orderable: false,
                    },
                    {
                        targets: 'no-search',
                        searchable: false,
                    },
                    {
                        target: 'hidden',
                        visible: false,
                    },
                ],
                columns: [{
                        data: 'plus_icon',
                        name: 'plus_icon',
                        'class': 'text-center'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        'class': 'text-center'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        'class': 'text-center'
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                        'class': 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'class': 'text-center'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        'class': 'text-center'
                    }
                ],
                order: [5, 'desc'],
                language: {
                    processing: '<img src="/assets/img/loading.gif" width="80px"/> <p class="m-0">...Loading...</p>',
                    paginate: {
                        previous: '<i class="bi bi-arrow-left-circle-fill"></i>',
                        next: '<i class="bi bi-arrow-right-circle-fill"></i>'
                    }
                }
            });

            $(document).on('click', '.delete-btn', function() {
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
                            url: `/project/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                table.ajax.reload();
                                toastr.info('Project deleted.')
                            }
                        })
                    }
                })
            })


        })
    </script>
@endsection
