@extends('user.layouts.master')
@section('title', 'Change Password')
@section('content')
    <div class="pagetitle">
        <h1>Change Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Setting</li>
                <li class="breadcrumb-item active"><a href="{{ route('user.change_password') }}">Change Password</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body py-4 px-3">
                    <form action="{{ route('user.update_password') }}" method="POST" id="create-form">
                        @csrf
                        <div class="row align-items-center mb-3">
                            <div class="col-md-4 fw-bold small">Current Password</div>
                            <div class="col-md-8">
                                <input type="password" name="current_password" class="form-control" />
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-4 fw-bold small">New Password</div>
                            <div class="col-md-8">
                                <input type="password" name="new_password" class="form-control" />
                            </div>
                        </div>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-4 fw-bold small">Confirm New Password</div>
                            <div class="col-md-8">
                                <input type="password" name="new_password_confirmation" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 offset-4">
                                <button type="submit" class="btn-theme">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePasswordRequest', '#create-form') !!}
@endsection
