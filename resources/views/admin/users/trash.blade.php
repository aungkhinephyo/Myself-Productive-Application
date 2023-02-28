@extends('admin.layouts.master')
@section('title', 'Recycle Bin')
@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('user.index') }}" class="btn-theme"><i class="bi bi-people-fill me-2"></i> User
                List</a>
        </div>

        <div class="card">
            <div class="card-body py-4 mb-0">
                <div class="table-responsive" id="trash_table"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            getTable();

            function getTable() {
                $.ajax({
                    url: '/admin/user/trash/data',
                    type: 'GET',
                    success: function(res) {
                        $('#trash_table').html(res);
                    }
                })
            }

            $(document).on('click', '.restore-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Do you want to restore?',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Restore'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/user/${id}/restore`,
                            type: 'POST',
                            success: function(res) {
                                getTable();
                                toastr.success('That user is restored.',
                                    'Success!');
                            }
                        })
                    }
                })
            })

            $(document).on('click', '.force-delete-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Do you want to delete it forever?',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Force Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/user/${id}/force_delete`,
                            type: 'POST',
                            success: function(res) {
                                getTable();
                                toastr.success('That user is deleted forever.',
                                    'Success!');
                            }
                        })
                    }
                })
            })

        })
    </script>
@endsection
