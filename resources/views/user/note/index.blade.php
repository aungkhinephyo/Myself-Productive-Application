@extends('user.layouts.master')
@section('preloading')
    <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="100px" />
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="pagetitle">
                <h1>Notes</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notes</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        </div>
        <div class="col-md-6 mb-3">
            <div class="search-bar px-md-4 px-0">
                <div class="search-form d-flex align-items-center">
                    <input type="text" name="s" id="search-box" placeholder="Search and press Enter"
                        title="Enter search keyword">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </div>
            </div><!-- End Search Bar -->
        </div>
    </div>
    <div class="mb-4">
        <a href="{{ route('note.create') }}" class="btn-theme">
            <span><i class="bi bi-plus-circle me-1"></i> New Note</span>
        </a>
    </div>
    <section id="my-notes" class="section"></section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            getNotes('');

            function getNotes(keyword) {
                $.ajax({
                    url: `/note/ssd?s=${keyword}`,
                    type: 'GET',
                    success: function(res) {
                        $('#my-notes').html(res);
                        /* preloading */
                        $('.preloading').css('display', 'none')
                    }
                })
            }

            $(document).on('change', '#search-box', function() {
                var keyword = $('#search-box').val();
                getNotes(keyword);
            })

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
                        $(this).parents('.note-container').remove();
                        $.ajax({
                            url: `/note/${id}`,
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(res) {

                                toastr.success('That note is deleted.')
                            }
                        })
                    }
                })
            })


        })
    </script>
@endsection
