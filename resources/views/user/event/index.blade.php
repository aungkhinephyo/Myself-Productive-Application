@extends('user.layouts.master')
@section('extra-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <style>
        .fc-event {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            padding: 3px 5px;
        }

        .fc-content .fc-title {
            white-space: normal !important;
        }
    </style>
@endsection
@section('preloading')
    <div class="preloading">
        <img src="{{ asset('assets/img/loading.gif') }}" class="loader" width="100px" />
    </div>
@endsection
@section('content')
    <div class="pagetitle mb-4">
        <h1>Calendar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="card">
        <div class="card-body py-4 mb-0">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="event-modal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="eventModalLabel">Create New Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="">Title</label>
                        <input type="text" name="title" id="title-input" class="form-control" />
                        <span id="title-error" class="text-danger small"></span>
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">Color</span>
                        <input type="color" name="color" id="color-input" class="form-control-color" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="save-btn" class="btn-theme"><i class="bi bi-save2 me-2"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {

            /* preloading */
            setTimeout(() => {
                $('.preloading').css('display', 'none')
            }, 2500);

            var events = @json($events);
            // console.log(events)

            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev next today',
                    center: 'title',
                    right: 'prevYear nextYear',
                    // right: 'month, agendaWeek, agendaDay',
                },
                events: events,

                /* create event */
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    $('#event-modal').modal('show');

                    $('#save-btn').unbind().click(function() {
                        var title = $('#title-input').val();
                        var color = $('#color-input').val();
                        var start_date = moment(start).format('YYYY-MM-DD');
                        var end_date = moment(end).format('YYYY-MM-DD');
                        // console.log(title, color, start_date, end_date);

                        $.ajax({
                            url: '/event',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                title: title,
                                start_date: start_date,
                                end_date: end_date,
                                color: color,
                            },
                            success: function(res) {
                                $('#title-input').val('');
                                $('#event-modal').modal('hide');

                                $('#calendar').fullCalendar('renderEvent', {
                                    id: res.id,
                                    title: res.title,
                                    start: res.start_date,
                                    end: res.end_date,
                                    color: res.color,
                                });
                            },
                            error: function(res) {
                                $('#title-error').html(res.responseJSON
                                    .errors
                                    .title);
                            }
                        })
                    })
                },

                /* drag and draw  and update date*/
                editable: true,
                eventDrop: function(event) {
                    var id = event.id;
                    var start_date = moment(event.start).format('YYYY-MM-DD');
                    var end_date = moment(event.end).format('YYYY-MM-DD');

                    $.ajax({
                        url: `/event/${id}`,
                        type: 'PATCH',
                        dataType: 'json',
                        data: {
                            start_date: start_date,
                            end_date: end_date
                        },
                        success: function(res) {
                            toastr.info('Event updated.')
                        }
                    })
                },

                /* edit or delete */
                eventClick: function(event) {
                    var id = event.id;
                    Swal.fire({
                        icon: 'info',
                        title: 'What do you want to do?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Edit',
                        denyButtonText: `Delete`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#event-modal').modal('show');
                            $('#title-input').val(event.title);
                            $('#color-input').val(event.color);
                            $('#save-btn').unbind().click(function() {
                                var title = $('#title-input').val();
                                var color = $('#color-input').val();

                                $.ajax({
                                    url: `/event/${id}`,
                                    type: 'PATCH',
                                    dataType: 'json',
                                    data: {
                                        title: title,
                                        color: color,
                                    },
                                    success: function(res) {
                                        $('#title-input').val('');
                                        $('#event-modal').modal(
                                            'hide');

                                        event.title = title;
                                        event.color = color;
                                        $('#calendar').fullCalendar(
                                            'updateEvent', event
                                        );
                                        toastr.info(
                                            'Event updated.')
                                    },
                                    error: function(res) {
                                        $('#title-error').html(res
                                            .responseJSON.errors
                                            .title);
                                    }
                                })
                            })
                        } else if (result.isDenied) {
                            Swal.fire({
                                text: "Are you sure to delete?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `/event/${id}`,
                                        type: 'DELETE',
                                        dataType: 'json',
                                        success: function(res) {
                                            $('#calendar')
                                                .fullCalendar(
                                                    'removeEvents',
                                                    res
                                                    .id);
                                            toastr.success(
                                                'Event deleted.'
                                            )
                                        }
                                    })
                                }
                            })
                        }
                    })
                },

                /* disable multiple select day */
                selectAllow: function(event) {
                    var start = moment(event.start).format('YYYY-MM-DD');
                    var end = moment(event.end).subtract(1, 'seconds').format('YYYY-MM-DD');
                    return start === end;
                },

            });

        })
    </script>
@endsection
