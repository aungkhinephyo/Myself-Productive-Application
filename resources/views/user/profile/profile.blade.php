@extends('user.layouts.master')
@section('preloading')
    <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="100px" />
    </div>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

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
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active  profile-overview" id="profile-overview">
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

                            </div><!-- End Profile Details -->

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="{{ route('user.update_profile') }}" method="POST" id="edit-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="{{ $user->profile_img() }}" id="profile-img-preview" alt="Profile">
                                            <label class="btn btn-primary btn-sm ms-2" for="upload-img"><i
                                                    class="bi bi-upload text-white"></i>
                                                <input type="file" name="profile_img" class="form-control d-none"
                                                    id="upload-img" accept="image/jpg, image/jpeg, image/png" />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="fullName"
                                                value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="about" class="form-control" id="about" style="height: 100px">{{ old('about', $user->about) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="job" type="text" class="form-control" id="Job"
                                                value="{{ old('job', $user->job) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="number" class="form-control" id="Phone"
                                                value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email"
                                                value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="twitter" type="url" class="form-control" id="Twitter"
                                                value="{{ old('twitter', $user->twitter) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="facebook" type="url" class="form-control" id="Facebook"
                                                value="{{ old('facebook', $user->facebook) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="instagram" type="url" class="form-control" id="Instagram"
                                                value="{{ old('instagram', $user->instagram) }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin
                                            Profile</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="linkedin" type="url" class="form-control" id="Linkedin"
                                                value="{{ old('linkedin', $user->linkedin) }}">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn-theme">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            /* preloading */
            setTimeout(() => {
                $('.preloading').css('display', 'none')
            }, 2500);

            const input = document.querySelector('#upload-img');

            $(document).on('change', '#upload-img', function() {
                console.log(this.files);
                let link = URL.createObjectURL(this.files[0]);
                $('#profile-img-preview').attr('src', link);
            })

        })
    </script>
@endsection
