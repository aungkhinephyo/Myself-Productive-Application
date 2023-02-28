@extends('admin.layouts.master')
@section('title', 'Edit Profile')
@section('content')
    <div class="card py-4 px-3">
        <div class="card-body">
            <form action="{{ route('admin.update_profile') }}" method="POST" id="edit-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" />
                </div>
                <div class="form-group mb-3">
                    <label for="">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" />
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone Number <span class="text-danger">*</span></label>
                    <input type="number" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" />
                </div>
                <div class="form-group mb-3">
                    <label for="">Current Job <span class="text-danger">*</span></label>
                    <input type="text" name="job" class="form-control" value="{{ old('job', $user->job) }}" />
                </div>
                <div class="form-group mb-3">
                    <label for="">About you</label>
                    <textarea name="about" class="form-control" placeholder="Describe yourself (Optional)">{{ old('about', $user->about) }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="">Profile Image</label>
                    <input type="file" name="profile_img" class="form-control img-input" />
                    <div class="preview-img"></div>
                </div>
                <div class="text-center mb-4">
                    <button type="submit" class="btn-theme w-50">Confirm</button>
                    <p class="text-muted small mb-0 mt-3">You can update at this point or connect social accounts and then
                        confirm.</p>
                </div>

                <hr>

                <h6 class="mt-4 mb-3"><i class='bi bi-link-45deg'></i> Connect Social Medias <span
                        class="text-muted">(Optional)</span></h6>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-light"><i class='bi bi-twitter text-info'></i></span>
                    <input type="url" name="twitter" class="form-control" placeholder="Your Twitter Link"
                        value="{{ old('twitter', $user->twitter) }}" />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light"><i class='bi bi-facebook text-primary'></i></span>
                    <input type="url" name="facebook" class="form-control" placeholder="Your Facebook Link"
                        value="{{ old('facebook', $user->facebook) }}" />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light"><i class='bi bi-instagram text-danger'></i></span>
                    <input type="url" name="instagram" class="form-control" placeholder="Your Instagram Link"
                        value="{{ old('instagram', $user->instagram) }}" />
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light"><i class='bi bi-linkedin text-primary'></i></span>
                    <input type="url" name="linkedin" class="form-control" placeholder="Your Linkedin Link"
                        value="{{ old('linkedin', $user->linkedin) }}" />
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest', '#edit-form') !!}
    <script>
        $(document).ready(function() {
            const input = document.querySelector('.img-input');

            $(document).on('change', '.img-input', function() {
                $('.preview-img').html('');
                let length = input.files.length;
                let images = '';
                for (let i = 0; i < length; i++) {
                    images += `<img src="${URL.createObjectURL(this.files[i])}" alt="profile-picture"/>`
                }
                $('.preview-img').html(images)
            })

        })
    </script>
@endsection
