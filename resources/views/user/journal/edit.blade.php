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
    </style>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Update Journal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('journal.index') }}">Journals</a></li>
                <li class="breadcrumb-item active">Update Journal</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-body py-4">
                        <form action="" id="edit-form">
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <span class="save-link save-btn" data-id="{{ $journal->id }}">Save Now</span>
                                    <p class="mb-0 small"><em><i class="bi bi-check text-success"></i> Saved
                                            {{ Carbon\Carbon::parse($journal->updated_at)->diffForHumans() }}</em></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Title</div>
                                <span class="me-2">:</span>
                                <div>
                                    <input type="text" name="title" class="borderless-input p-0" placeholder="Title"
                                        value="{{ old('title', \Stevebauman\Purify\Facades\Purify::clean($journal->title)) }}">
                                    <small id="title-error" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Date</div>
                                <span class="me-2">:</span>
                                <div>
                                    <input type="text" name="date" class="borderless-input p-0 datepicker"
                                        value="{{ old('date', $journal->date) }}" />
                                    <small id="date-error" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="input-name">Rating</div>
                                <span class="me-2">:</span>
                                <div>
                                    <select name="rating" class="borderless-input py-0 px-2" id="rate-your-day">
                                        <option value="" disabled>How do you feel today?</option>
                                        <option value="5" @if ($journal->rating == 5) selected @endif>
                                            Outstanding.
                                        </option>
                                        <option value="4" @if ($journal->rating == 4) selected @endif>Pretty
                                            good.
                                        </option>
                                        <option value="3" @if ($journal->rating == 3) selected @endif>Just okay.
                                        </option>
                                        <option value="2" @if ($journal->rating == 2) selected @endif>Not great
                                        </option>
                                        <option value="1" @if ($journal->rating == 1) selected @endif>It is hard.
                                        </option>
                                    </select>
                                    <small id="rating-error" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="content" id="summernote" class="form-control preservelines">
                                {!! \Stevebauman\Purify\Facades\Purify::clean($journal->content) !!}
                                </textarea>
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

            $(document).on('click', '.save-btn', function() {
                $('.save-btn').html('Saving...');
                var id = $(this).data('id');
                var formData = $("#edit-form").serialize();
                // console.log(formData);
                $.ajax({
                    url: `/journal/${id}`,
                    type: 'PUT',
                    dataType: 'json',
                    data: formData,
                    success: function(res) {
                        $('#title-error').html('');
                        $('#date-error').html('');
                        $('#rating-error').html('');
                        toastr.info('Journal updated.')
                        $('.save-btn').html('Save Now');
                    },
                    error: function(res) {
                        res.responseJSON.errors.title ? $('#title-error').html(res.responseJSON
                            .errors.title) : $('#title-error').html('');
                        res.responseJSON.errors.date ? $('#date-error').html(res.responseJSON
                            .errors.date) : $('#date-error').html('');
                        res.responseJSON.errors.rating ? $('#rating-error').html(res
                            .responseJSON.errors.rating) : $('#rating-error').html('');
                        $('.save-btn').html('Save Now');
                    }
                })
            })

        })
    </script>
@endsection
