@extends('admin.layouts.master')
@section('title', 'Create Role')
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('role.store') }}" method="POST" id="create-form">
                @csrf
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">Name</span>
                    <input type="text" name="name" class="form-control" autofocus />
                </div>
                <div class="text-start my-3">
                    <button type="button" class="btn btn-primary btn-sm toggle-permission-btn">Toggle all</button>
                </div>
                <div class="row mb-4">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-group mb-1">
                                <input type="checkbox" name="permission[]" id="checkbox_{{ $permission->id }}"
                                    value="{{ $permission->name }}" />
                                <label for="checkbox_{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endforeach
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StoreRoleRequest', '#create-form') !!}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.toggle-permission-btn', function() {
                $('input[type=checkbox]').prop("checked", !$('input[type=checkbox]').prop("checked"));
            })
        })
    </script>
@endsection
