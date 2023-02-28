@extends('user.layouts.master')
@section('content')
    <div class="pagetitle">
        <h1>Read Note</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('note.index') }}">Notes</a></li>
                <li class="breadcrumb-item active">Read or Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-0">
                    <div class="card-body p-3 shadow-lg">
                        <form action="{{ route('note.update', $note->id) }}" method="POST" id="edit-form">
                            @method('PUT')
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="title" class="borderless-input title-input border-bottom"
                                    placeholder="Untitled"
                                    value="{{ old('title', \Stevebauman\Purify\Facades\Purify::clean($note->title)) }}">
                            </div>
                            <div class="form-group">
                                <textarea name="content" class="borderless-input preservelines border-bottom resize-none" rows="14"
                                    placeholder="Tab here to continue...">{!! \Stevebauman\Purify\Facades\Purify::clean($note->content) !!}</textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn-theme">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\User\StoreNoteRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {})
    </script>
@endsection
