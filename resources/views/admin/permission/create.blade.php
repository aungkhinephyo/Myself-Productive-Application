@extends('admin.layouts.master')
@section('title', 'Create Permission')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('permission.store') }}" method="POST" id="create-form">
                @csrf
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">Name</span>
                    <input type="text" name="name" class="form-control" autofocus />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn-theme w-50">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StorePermissionRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {})
    </script>
@endsection
