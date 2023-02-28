@extends('admin.layouts.master')
@section('title', 'Roles')
@section('content')
    @can('create role')
        <div class="d-flex justify-content-start py-4">
            <a href="{{ route('role.create') }}" class="btn-theme"><i class="bi bi-plus-circle me-1"></i> Create New
                Role</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body py-4 mb-0">
            <table id="Datatable" class="table table-hover Datatable" style="width:100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Permissions</th>
                    <th class="text-center no-sort no-search @hasrole(['admin', 'user']) hidden @endhasrole">Actions</th>
                    <th class="text-center no-search hidden">Updated At</th>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('.Datatable').DataTable({
                ajax: '/admin/role/datatable/ssd',
                columns: [{
                        data: 'plus_icon',
                        name: 'plus_icon',
                        'class': 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        'class': 'text-center'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        'class': 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'class': 'text-center'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        'class': 'text-center'
                    },
                ],
                order: [4, 'desc']
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
                            url: `/admin/role/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                table.ajax.reload();
                                toastr.success('That role is deleted.')
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
