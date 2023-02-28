@extends('user.layouts.master')
@section('content')
    <div class="pagetitle">
        <h1>New Note</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('note.index') }}">Notes</a></li>
                <li class="breadcrumb-item active">Create Note</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-0">
                    <div class="card-body p-3 shadow-lg">
                        <form action="{{ route('note.store') }}" method="POST" id="create-form">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="title" class="borderless-input title-input border-bottom"
                                    placeholder="Untitled">
                            </div>
                            <div class="form-group">
                                <textarea name="content" class="borderless-input preservelines border-bottom resize-none" rows="14"
                                    placeholder="Tab here to continue..."></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\User\StoreNoteRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {


        })
    </script>
@endsection
