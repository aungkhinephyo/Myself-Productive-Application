@extends('user.layouts.master')
@section('content')
    <div class="pagetitle">
        <h1>Contact Us</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('user.contact') }}">Contact</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fs-4">Contact Us</h5>

                    <!-- Contact Form  -->
                    <form action="https://formspree.io/f/xvonkllv" method="POST" id="contact-form">
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label">Your Name</label>
                            <div class="col-sm-10">
                                <input name="Name" type="text" class="form-control" id="inputName" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="Email" type="email" class="form-control" id="inputEmail" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputSubject" class="col-sm-2 col-form-label">Subject</label>
                            <div class="col-sm-10">
                                <input name="Subject" type="text" list="subjects" class="form-control" id="inputSubject"
                                    required autocomplete="off" />
                                <datalist id="subjects">
                                    <option value="User Experience">
                                    <option value="User Interface">
                                    <option value="Errors">
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputMessage" class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <textarea name="Message" id="inputMessage" class="form-control" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" required>
                                    <label class="form-check-label" for="gridCheck1">
                                        <small class="text-muted">Agree to terms & conditions.</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" id="submit-btn" class="btn-theme">Submit</button>
                            </div>
                        </div>
                        <p id="my-form-status"></p>
                    </form><!-- End Contact Form -->

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // $(document).on('submit', '#contact-form', function(e) {
        //     // $(this)[0].reset();
        // })

        var form = document.getElementById("contact-form");
        async function handleSubmit(event) {
            event.preventDefault();
            var status = document.getElementById("my-form-status");
            var data = new FormData(event.target);
            fetch(event.target.action, {
                method: form.method,
                body: data,
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succeed',
                        text: 'Your mail has been sent.',
                    })
                    form.reset()
                } else {
                    response.json().then(data => {
                        if (Object.hasOwn(data, 'errors')) {
                            status.innerHTML = data["errors"].map(error => error["message"]).join(", ")
                        } else {
                            status.innerHTML = "Oops! There was a problem submitting your form"
                        }
                    })
                }
            }).catch(error => {
                status.innerHTML = "Oops! There was a problem submitting your form"
            });
        }
        form.addEventListener("submit", handleSubmit)
    </script>
@endsection
