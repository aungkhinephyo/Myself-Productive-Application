@extends('admin.layouts.master')
@section('title', 'Edit Permission')
@section('content')
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-5"> --}}
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('permission.update', $permission->id) }}" method="POST" id="edit-form">
                @method('PUT')
                @csrf
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">Name</span>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn-theme w-50">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    {{-- </div> --}}
    {{-- </div> --}}
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdatePermissionRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {})
    </script>
@endsection
