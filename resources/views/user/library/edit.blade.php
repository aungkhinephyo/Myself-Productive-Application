@extends('user.layouts.master')
@section('extra-css')
    <style>
        .input-group-text {
            display: inline-block;
            min-width: 100px;
            text-align: center
        }
    </style>
@endsection
@section('content')
    <div class="pagetitle mb-4">
        <h1>Update Link</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('library.index') }}">Library</a></li>
                <li class="breadcrumb-item active">Update link</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card mb-0">
                    <div class="card-body px-3 py-4 shadow-lg">
                        <form action="{{ route('library.update', $library->id) }}" method="POST" id="edit-form">
                            @method('PUT')
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Title</span>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $library->title) }}" />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Link</span>
                                <input type="url" name="link" class="form-control"
                                    value="{{ old('title', $library->link) }}" />
                            </div>
                            <div class="input-group mb-4">
                                <label class="input-group-text" for="inputGroupSelect01">Type</label>
                                <select class="form-select" name="library_type_id">
                                    <option value="" selected disabled>Choose type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            @if ($library->library_type_id == $type->id) selected @endif>{{ ucfirst($type->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn-theme w-50">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateLibraryRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {})
    </script>
@endsection
