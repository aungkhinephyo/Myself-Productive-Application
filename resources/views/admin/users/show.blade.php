@extends('admin.layouts.master')
@section('title', 'User Details')
@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ $user->profile_img() }}" alt="Profile" class="rounded-circle">
                        <h2 class="text-capitalize mb-1">{{ $user->name }}</h2>
                        <h3 class="text-capitalize">{{ $user->job }}</h3>
                        <div class="social-links mt-2">
                            <a href="@if ($user->twitter) {{ $user->twitter }} @else javascript:void(0); @endif"
                                class="twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                            <a href="@if ($user->facebook) {{ $user->facebook }} @else javascript:void(0); @endif"
                                class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a href="@if ($user->instagram) {{ $user->instagram }} @else javascript:void(0); @endif"
                                class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                            <a href="@if ($user->linkedin) {{ $user->linkedin }} @else javascript:void(0); @endif"
                                class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav justify-content-center nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">
                                    @if ($user->about)
                                        {{ $user->about }}
                                    @else
                                        This user does not update about him yet.
                                    @endif
                                </p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8 text-capitalize">{{ $user->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8 text-capitalize">
                                        @if ($user->job)
                                            {{ $user->job }}
                                        @else
                                            <span class="text-muted">Empty</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>

                            </div>
                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
