@extends('admin.layouts.master')
@section('title', 'Users')
@section('content')
    @can('create user')
        <div class="d-flex justify-content-start py-4">
            <a href="{{ route('user.create') }}" class="btn-theme"><i class="bi bi-plus-circle me-1"></i> Create New User</a>
        </div>
    @endcan
    <div class="card">
        <div class="card-body py-4 mb-0">
            <table id="Datatable" class="table table-hover Datatable" style="width:100%">
                <thead>
                    <th class="text-center no-sort no-search"></th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Job</th>
                    <th class="text-center hidden">Role</th>
                    <th class="text-center no-sort no-search">Actions</th>
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
                ajax: '/admin/user/datatable/ssd',
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
                        data: 'email',
                        name: 'email',
                        'class': 'text-center'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        'class': 'text-center'
                    },
                    {
                        data: 'job',
                        name: 'job',
                        'class': 'text-center'
                    },
                    {
                        data: 'role',
                        name: 'role',
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
                order: [7, 'desc']
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
                            url: `/admin/user/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                table.ajax.reload();
                                toastr.success('That user is deleted.')
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
