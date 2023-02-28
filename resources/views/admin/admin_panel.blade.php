@extends('admin.layouts.master')
@section('title', 'Admin Panel')
@section('content')
    <section class="section dashboard">
        <div class="row">

            <!-- User Card -->
            <div class="col-xxl-4 col-md-4">
                <a href="{{ route('user.index') }}">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Users <span>| Overall</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $userCount }}</h6>
                                    <span class="text-success small pt-1 fw-bold">12%</span> <span
                                        class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div><!-- End User Card -->

            <!-- Todolist Type Card -->
            <div class="col-xxl-4 col-md-4">
                <a href="{{ route('todolist_type.index') }}">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">To-do List Types</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $todolistTypeCount }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div><!-- End Todolist Type Card -->

            <!-- Library Type Card -->
            <div class="col-xxl-4 col-md-4">
                <a href="{{ route('library_type.index') }}">
                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Library Types</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-folder-symlink-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $libraryTypeCount }}</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div><!-- End Library Type Card -->

            <!-- App User Tracker Chart Card -->
            <div class="col-xxl-4 col-md-7">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">App Users<span> | Monthly</span></h5>

                        <div>
                            <canvas id="myUserChart"></canvas>
                        </div>
                    </div>

                </div>
            </div><!-- End App User Tracker Chart Card -->

            <!--User Job Tracker Chart Card -->
            <div class="col-xxl-4 col-md-5">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">User Jobs<span> | Overall</span></h5>

                        <div>
                            <canvas id="myJobChart"></canvas>
                        </div>
                    </div>

                </div>
            </div><!-- EndUser Job Tracker Chart Card -->

        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myUserChart');
        const lineXData = @json($months);
        const lineYData = @json($userChartCount);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: lineXData,
                datasets: [{
                    label: 'App user increment by month',
                    data: lineYData,
                    fill: true,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });

        const ctx2 = document.getElementById('myJobChart');
        const pieXData = @json($jobs);
        const pieYData = @json($jobChartCount);
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: pieXData,
                datasets: [{
                    label: 'User Jobs',
                    data: pieYData,
                }],
                hoverOffset: 4
            }
        });
    </script>
@endsection
