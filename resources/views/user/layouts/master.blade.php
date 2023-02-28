<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>MYSELF</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- favicon --}}
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png" sizes="16x16" />

    {{-- google fonts --}}
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet" />

    {{-- icons --}}
    <link href="{{ asset('assets/icons/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    {{-- toastr --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    {{-- Daterange Picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{-- image viewerjs --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.2/viewer.min.css">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />

    {{-- custom css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-2.css') }}" />

    @yield('extra-css')
</head>

<body class="">
    {{-- class="toggle-sidebar" --}}

    <!-- ======= Header ======= -->
    @include('user.partials.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('user.partials.sidebar')
    <!-- End Sidebar-->

    <!-- ======= Main Content ====== -->
    <main id="main" class="main">
        @yield('preloading')
        @yield('content')
    </main>
    <!-- End #main -->

    {{-- preloading --}}
    {{-- <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="120px"/>
    </div> --}}

    {{-- back to top --}}
    {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a> --}}

    {{-- jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {{-- sweetalert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- toastr --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Daterange Picker --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    {{-- image viwerjs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.2/viewer.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {

            let token = document.head.querySelector('meta[name="csrf-token"]');
            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.content
                    }
                });
            } else {
                console.log('CSRF token not found!.');
            }

            /* preloading */
            // setTimeout(() => {
            //     $('.preloading').css('display', 'none')
            // }, 4000);

            /* toastr */
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "2000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            $(document).on('click', '.logout-btn', function() {
                Swal.fire({
                    title: 'Do you want to logout?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/logout',
                            type: 'POST',
                            dataType: 'json',
                            success: function(res) {
                                window.location.href = '/';
                            }
                        })
                    }
                })
            })
        });
    </script>

    @yield('script')
</body>

</html>
