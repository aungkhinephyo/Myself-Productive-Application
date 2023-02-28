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

    {{-- datatable --}}
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />

    {{-- toastr --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />

    {{-- custom css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}" />

    @yield('extra-css')
</head>

<body class="toggle-sidebar">
    {{-- class="toggle-sidebar" --}}

    <!-- ======= Header ======= -->
    @include('admin.partials.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('admin.partials.sidebar')
    <!-- End Sidebar-->

    <!-- ======= Main Content ====== -->
    <main id="main" class="main">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </main>
    <!-- End #main -->

    {{-- back to top --}}
    {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a> --}}

    {{-- jquery --}}
    <script src="{{ asset('assets/libs/jquery/jquery-3.6.3.min.js') }}"></script>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    {{-- datatable --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {{-- sweetalert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- toastr --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

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

            // $(document).on('click', '.toggle-sidebar-btn', function() {
            //     $('body').toggleClass('toggle-sidebar');
            // })

            // document.addEventListener('click', function(e) {
            //     var toggleBtn = $('.toggle-sidebar-btn');

            //     if (!document.getElementById('sidebar').contains(e.target) && e.target !== toggleBtn[0]) {
            //         document.body.classList.add('toggle-sidebar');
            //     }
            // })

            /* toastr */
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
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

            /* select2 */
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            /* datatable default value */
            $.extend(true, $.fn.dataTable.defaults, {
                processing: true,
                serverSide: true,
                responsive: true,
                mark: true,
                columnDefs: [{
                        target: 0,
                        class: "control",
                        orderable: false,
                    },
                    {
                        target: 'no-sort',
                        orderable: false,
                    },
                    {
                        targets: 'no-search',
                        searchable: false,
                    },
                    {
                        target: 'hidden',
                        visible: false,
                    },
                ],
                language: {
                    processing: '<img src="/assets/img/loading.gif" width="80px"/> <p class="m-0">...Loading...</p>',
                    paginate: {
                        previous: '<i class="bi bi-arrow-left-circle-fill"></i>',
                        next: '<i class="bi bi-arrow-right-circle-fill"></i>'
                    }
                }
            });

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
