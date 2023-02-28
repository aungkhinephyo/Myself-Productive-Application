@extends('user.layouts.master')
@section('extra-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame .note-editing-area .note-editable {
            background: #fff;
        }

        .input-name {
            min-width: 80px;
            font-weight: bold;
            font-size: 16px;
        }

        select {
            appearance: none;
        }

        button[type="submit"] {
            border: 0;
            outline: 0;
            background: transparent;
        }
    </style>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Today Journal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('journal.index') }}">Journals</a></li>
                <li class="breadcrumb-item active">Create Journal</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-body py-4">
                        <form action="{{ route('journal.store') }}" method="POST" id="create-form">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="save-link save-btn">Save Now</button>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Title</div>
                                <span class="me-2">:</span>
                                <div>
                                    <input type="text" name="title" class="borderless-input p-0" placeholder="Title">
                                    <small id="title-error" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Date</div>
                                <span class="me-2">:</span>
                                <div>
                                    <input type="text" name="date" class="borderless-input p-0 datepicker"
                                        value="{{ old('date') }}" />
                                    <small id="date-error" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Rating</div>
                                <span class="me-2">:</span>
                                <div>
                                    <select name="rating" class="borderless-input py-0 px-2" id="rate-your-day">
                                        <option value="" selected disabled>How do you feel today?</option>
                                        <option value="5">Outstanding.</option>
                                        <option value="4">Pretty good.</option>
                                        <option value="3">Just okay.</option>
                                        <option value="2">Not great</option>
                                        <option value="1">It is hard.</option>
                                    </select>
                                    <small id="rating-error" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="content" id="summernote" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="text-start">
                            {{ Carbon\Carbon::today()->format('D d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    {!! JsValidator::formRequest('App\Http\Requests\User\StoreJournalRequest', '#create-form') !!}

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

            $('#summernote').summernote({
                placeholder: 'How is your day?',
                tabsize: 2,
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'forecolor']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'help']]
                ]
            });
        })
    </script>
@endsection
