@extends('user.layouts.master')
@section('preloading')
    <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="100px" />
    </div>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Task Card -->
                    <div class="col-xxl-4 col-md-6">
                        <a href="{{ route('todolist.index') }}">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title">Tasks <span>| Today</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ui-checks-grid"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $todayTodolistCount }}</h6>
                                            @if ($todayTodolistCount > 0)
                                                <span class="text-primary small pt-1 fw-bold">Left to do</span>
                                            @else
                                                <span class="small pt-1 fw-bold">No task left to do.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div><!-- End Task Card -->

                    <!-- Completed Task Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Tasks Completed<span> | Overall</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $completedTodolistCount }}</h6>
                                        <span class="text-success small pt-1 fw-bold">Completed</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Completed Task Card -->

                    <!-- Task Tracker Chart Card -->
                    <div class="col-xxl-4 col-md-12">
                        <div class="card info-card revenue-card">
                            {{-- {{ dd($start) }} --}}
                            <div class="card-body">
                                <h5 class="card-title">Task Tracker<span> | Daily</span></h5>

                                <div>
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Task Tracker Chart Card -->

                    <!-- Others Data Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Others <span>| Overall</span></h5>

                                <div class="row">
                                    <div class="col-md-6 p-2 mb-4">
                                        <a href="{{ route('note.index') }}">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-sticky"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{ $noteCount }}</h6>
                                                    <span class="text-danger small pt-1 fw-bold">Notes</span>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 p-2 mb-4">
                                        <a href="{{ route('journal.index') }}">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-journal-bookmark-fill"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{ $journalCount }}</h6>
                                                    <span class="text-danger small pt-1 fw-bold">Daily Journals</span>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 p-2 mb-4">
                                        <a href="{{ route('library.index') }}">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-bookmark"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{ $libraryCount }}</h6>
                                                    <span class="text-danger small pt-1 fw-bold">Library Links</span>

                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 p-2 mb-4">
                                        <a href="{{ route('project.index') }}">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-folder"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>{{ $projectCount }}</h6>
                                                    <span class="text-danger small pt-1 fw-bold">Projects</span>

                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div><!-- End Others Data Card -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Special Event Card -->
                <div class="card info-card">

                    <div class="card-body" style="min-height: 149.594px;">
                        <h5 class="card-title">Special Events <span>| Today</span></h5>
                        @forelse ($events as $event)
                            <div class="d-flex align-items-center mt-3">
                                <div
                                    class="card-icon2 bg-info-light text-primary rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gem"></i>
                                </div>
                                <div class="ms-2">
                                    <span class="text-capitalize small fw-bold">{{ $event->title }}</span>
                                </div>
                            </div>
                        @empty
                            <span class="text-muted fw-bold small">No event today.</span>
                        @endforelse
                    </div>
                </div> <!-- End Special Event Card -->

                <!-- Recent Activity -->
                <div class="card">

                    <div class="card-body" style="min-height: 158.594px;">
                        <h5 class="card-title">Recent Activities</h5>

                        <div class="activity">

                            @forelse  ($activities as $activity)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">
                                        {{ Carbon\Carbon::parse($activity->date)->diffForHumans(null, true) }}
                                    </div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">{{ $activity->title }}</div>
                                </div><!-- End activity item-->
                            @empty
                                <span class="text-muted fw-bold">No recent activity</span>
                            @endforelse

                        </div>

                    </div>
                </div><!-- End Recent Activity -->

            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        /* preloading */
        setTimeout(() => {
            $('.preloading').css('display', 'none')
        }, 2000);

        const labels = @json($days);
        const data = @json($trackData);

        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tasks Completed',
                    data: data,
                    fill: true,
                    borderColor: '#16e96e',
                    tension: 0.1
                }]
            }
        });
    </script>
@endsection
