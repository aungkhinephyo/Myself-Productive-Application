@extends('admin.layouts.master')
@section('title', 'Create Todolist Type')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('todolist_type.store') }}" method="POST" id="create-form">
                        @csrf
                        <div class="input-group mb-4">
                            <span class="input-group-text" id="basic-addon1">Name</span>
                            <input type="text" name="name" class="form-control" autofocus />
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-text" id="basic-addon1">Color</span>
                            <input type="color" name="color" class="form-control-color" />
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-theme">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreTodolistTypeRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {})
    </script>
@endsection
