<header id="header" class="header fixed-top d-flex align-items-center justify-content-between">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.admin_panel') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="50px" height="50px" />
            <span class="d-none d-lg-block">MYSELF</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div>
        <h5 class="fw-bolder mb-0">@yield('title')</h5>
    </div><!-- End Search Bar -->

    <nav class="header-nav">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->profile_img() }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a>
                <!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6 class="text-capitalize">{{ auth()->user()->name }}</h6>
                        <span class="text-capitalize">{{ auth()->user()->job }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="{{ route('admin.profile') }}" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
