@extends('user.layouts.master')
@section('content')
    <div class="pagetitle">
        <h1>Read Journal</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('journal.index') }}">Journals</a></li>
                <li class="breadcrumb-item active">Read Journal</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-body py-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="text-center fw-bold mb-0">
                                    {{ \Stevebauman\Purify\Facades\Purify::clean($journal->title) }}
                                </h5>
                                <div class="text-end">
                                    <a href="{{ route('journal.edit', $journal->id) }}"><i
                                            class="bi bi-pencil-square fs-4"></i></a>
                                    <p class="mb-0 small"><em>Saved
                                            {{ Carbon\Carbon::parse($journal->updated_at)->diffForHumans() }}</em></p>
                                </div>
                            </div>
                            <p class="mb-0 text-center title-cross fw-bold">
                                <span>{{ Carbon\Carbon::parse($journal->updated_at)->format('F d / Y') }}</span>
                            </p>
                        </div>
                        <div class="preservelines pt-4">{!! \Stevebauman\Purify\Facades\Purify::clean($journal->content) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {})
    </script>
@endsection
