@extends('admin.layouts.master')
@section('title', 'Edit Role')
@section('content')
    {{-- <div class="row justify-content-center"> --}}
    {{-- <div class="col-md-5"> --}}
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('role.update', $role->id) }}" method="POST" id="edit-form">
                @method('PUT')
                @csrf
                <div class="input-group mb-4">
                    <span class="input-group-text" id="basic-addon1">Name</span>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" />
                </div>
                <div class="text-start my-3">
                    <button type="button" class="btn btn-sm btn-primary toggle-permission-btn">Toggle all</button>
                </div>
                <div class="row mb-4">
                    @foreach ($permissions as $permission)
                        <div class="col-md-3">
                            <div class="form-group mb-1">
                                <input type="checkbox" name="permission[]" id="checkbox_{{ $permission->id }}"
                                    value="{{ $permission->name }}" @if (in_array($permission->name, $old_permissions)) checked @endif />
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
    {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateRoleRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.toggle-permission-btn', function() {
                $('input[type=checkbox]').prop("checked", !$('input[type=checkbox]').prop("checked"));
            })
        })
    </script>
@endsection
