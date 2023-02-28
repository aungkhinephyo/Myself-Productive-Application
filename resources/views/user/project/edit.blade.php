@extends('user.layouts.master')
@section('content')
    <div class="pagetitle">
        <h1>Edit Project</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Projects</a></li>
                <li class="breadcrumb-item active">Edit Project</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-0">
                    <div class="card-body px-3 py-4 shadow-lg">
                        <form action="{{ route('project.update', $project->id) }}" method="POST" id="edit-form"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Project Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $project->title) }}" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $project->description) }}</textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Start Date</label>
                                <input type="text" name="start_date" class="form-control datepicker"
                                    value="{{ old('start_date', $project->start_date) }}" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Deadline</label>
                                <input type="text" name="deadline" class="form-control datepicker"
                                    value="{{ old('deadline', $project->deadline) }}" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Project Images</label>
                                <input type="file" name="images[]" class="form-control mb-1 img-input"
                                    accept="image/jpg, image/jpeg, image/png" multiple />
                                <div class="preview-img">
                                    @if ($project->images)
                                        @foreach ($project->images ?? [] as $image)
                                            <img src="{{ $project->img_path() . '/' . $image }}" alt="project-image">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label">Project Files</label>
                                <input type="file" name="files[]" class="form-control pdf-input" accept="application/pdf"
                                    multiple />
                                <div class="preview-pdf d-flex flex-wrap">
                                    @if ($project->files)
                                        @foreach ($project->files ?? [] as $file)
                                            <a href="{{ $project->file_path() . '/' . $file }}" target="_blank"
                                                class="pdf-thumbnail" title="{{ $file }}}">
                                                <i class="bi bi-filetype-pdf"></i>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\User\UpdateProjectRequest', '#edit-form') !!}
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

            $(document).on('change', '.img-input', function() {
                $('.preview-img').html('');
                let length = this.files.length;
                let images = '';
                for (let i = 0; i < length; i++) {
                    images += `<img src="${URL.createObjectURL(this.files[i])}" alt="project-images"/>`
                }
                $('.preview-img').html(images)
            })

            $(document).on('change', '.pdf-input', function() {
                $('.preview-pdf').html('');
                let length = this.files.length;
                let pdfs = '';
                for (let i = 0; i < length; i++) {
                    pdfs += `<a href="javascript:void(0);"
                                class="pdf-thumbnail" title="${this.files[i].name}">
                                <i class="bi bi-filetype-pdf"></i>
                            </a>`;
                }
                $('.preview-pdf').html(pdfs)
            })

        })
    </script>
@endsection
