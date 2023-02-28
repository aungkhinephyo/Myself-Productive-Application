@extends('user.layouts.master')
@section('extra-css')
    <style>
        .input-name {
            display: inline-block;
            min-width: 50px;
            font-weight: bold;
            font-size: 16px;
        }

        .datepicker {
            border: none;
            outline: none;
            padding: 0;
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
        <h1>Task History</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('todolist.index') }}">To-do List</a></li>
                <li class="breadcrumb-item active">History</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body py-4 mb-0">
            <div class="row align-items-center">
                <div class="col-md-4 mb-md-0 mb-2">
                    <div class="d-flex">
                        <span class="input-name">From</span>
                        <span class="me-2">:</span>
                        <input type="text" name="start" id="start-date" class="datepicker"
                            value="{{ Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" />
                    </div>
                </div>
                <div class="col-md-4 mb-md-0 mb-2">
                    <div class="d-flex">
                        <span class="input-name">To</span>
                        <span class="me-2">:</span>
                        <input type="text" name="end" id="end-date" class="datepicker"
                            value="{{ Carbon\Carbon::now()->subDay()->format('Y-m-d') }}" />
                    </div>
                </div>
                <div class="col-md-4 mb-md-0 mb-2">
                    <button type="button" id="search-btn" class="btn-theme"><i class="bi bi-search me-1"></i>
                        Search</button>
                </div>
            </div>
        </div>
    </div>

    <div id="todolist-history"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD"
                },
            });
        })

        todolistData();

        function todolistData() {
            $.ajax({
                url: "/todolist/history/data",
                type: "GET",
                data: {
                    start: $('#start-date').val(),
                    end: $('#end-date').val(),
                },
                success: function(res) {
                    $('#todolist-history').html(res);
                    /* preloading */
                    $('.preloading').css('display', 'none');
                }
            })
        }

        $(document).on("click", "#search-btn", todolistData)
    </script>
@endsection
