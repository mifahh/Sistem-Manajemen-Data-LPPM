@extends('template.layout')

@section('title', 'Kalender Kegiatan LPPM ITTelkom Surabaya')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .fc-event {
            cursor: pointer;
        }
        .fc-day-today {
            background-color: #f8f9fa !important;
        }
        #calendar {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .fc-toolbar-title {
            color: #2c3e50;
            font-weight: 600;
        }
        .fc-button-primary {
            background-color: #2c3e50 !important;
            border-color: #2c3e50 !important;
        }
        .fc-button-primary:hover {
            background-color: #1a252f !important;
        }
    </style>
@endpush

@section('page-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 justify-content-end">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kalender PPM</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Kalender Kegiatan LPPM Telkom Unviersity Surabaya</h6>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Tambah Kegiatan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="eventForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="eventId">
                    <div class="form-group">
                        <label for="title">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="start">Tanggal Mulai</label>
                        <input type="datetime-local" class="form-control" id="start" name="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control" id="end" name="end">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var SITEURL = "{{ url('/') }}";
            var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
            var eventForm = document.getElementById('eventForm');
            var eventId = document.getElementById('eventId');
            var eventTitle = document.getElementById('title');
            var eventStart = document.getElementById('start');
            var eventEnd = document.getElementById('end');
            var currentEvent = null;

            // Initialize calendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                initialView: 'dayGridMonth',
                navLinks: true,
                selectable: true,
                selectMirror: true,
                select: function(arg) {
                    // Reset form
                    eventForm.reset();
                    eventId.value = '';

                    // Set default time (9 AM to 5 PM)
                    var start = new Date(arg.start);
                    var end = arg.end ? new Date(arg.end) : new Date(arg.start);

                    if (arg.allDay) {
                        start.setHours(9, 0, 0);
                        end.setDate(end.getDate() - 1);
                        end.setHours(17, 0, 0);
                    }

                    eventStart.value = start.toISOString().slice(0, 16);
                    eventEnd.value = end.toISOString().slice(0, 16);

                    // Show modal
                    eventModal.show();

                    // Save current selection
                    currentEvent = {
                        start: start,
                        end: end,
                        allDay: arg.allDay
                    };

                    calendar.unselect();
                },
                eventClick: function(arg) {
                    // Populate form with event data
                    eventId.value = arg.event.id;
                    eventTitle.value = arg.event.title;
                    eventStart.value = arg.event.start ? arg.event.start.toISOString().slice(0, 16) : '';
                    eventEnd.value = arg.event.end ? arg.event.end.toISOString().slice(0, 16) : '';

                    // Show modal
                    eventModal.show();

                    // Save current event
                    currentEvent = {
                        id: arg.event.id,
                        title: arg.event.title,
                        start: arg.event.start,
                        end: arg.event.end,
                        allDay: arg.event.allDay
                    };
                },
                eventDrop: function(arg) {
                    updateEvent({
                        id: arg.event.id,
                        title: arg.event.title,
                        start: arg.event.start ? arg.event.start.toISOString() : null,
                        end: arg.event.end ? arg.event.end.toISOString() : null
                    });
                },
                eventResize: function(arg) {
                    updateEvent({
                        id: arg.event.id,
                        title: arg.event.title,
                        start: arg.event.start ? arg.event.start.toISOString() : null,
                        end: arg.event.end ? arg.event.end.toISOString() : null
                    });
                },
                events: SITEURL + "/calender",
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventDisplay: 'block',
                eventColor: '#2c3e50',
                eventTextColor: '#ffffff',
                eventBackgroundColor: '#2c3e50',
                eventBorderColor: '#1a252f',
                eventDisplay: 'block',
                eventDidMount: function(info) {
                    // Add tooltip to events
                    if (info.event.extendedProps.description) {
                        $(info.el).tooltip({
                            title: info.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                }
            });

            calendar.render();

            // Handle form submission
            eventForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(eventForm);
                var eventData = {};

                // Convert FormData to object
                formData.forEach((value, key) => {
                    eventData[key] = value;
                });

                // Set type based on whether this is a new or existing event
                eventData.type = eventId.value ? 'update' : 'add';

                // If it's a new event, add the start and end dates from the selection
                if (!eventId.value && currentEvent) {
                    eventData.start = currentEvent.start.toISOString();
                    eventData.end = currentEvent.end.toISOString();
                }

                // Send AJAX request
                $.ajax({
                    url: SITEURL + "/calenderAjax",
                    type: "POST",
                    data: eventData,
                    success: function(response) {
                        if (response.success) {
                            // Refresh calendar
                            calendar.refetchEvents();
                            // Hide modal
                            eventModal.hide();
                            // Show success message
                            displayMessage(eventId.value ? 'Kegiatan berhasil diperbarui' : 'Kegiatan berhasil ditambahkan');
                        } else {
                            // Show error message
                            displayMessage('Terjadi kesalahan: ' + (response.message || 'Silakan coba lagi'), 'error');
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        displayMessage(errorMessage, 'error');
                    }
                });
            });

            // Handle delete button
            document.getElementById('deleteEvent').addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
                    $.ajax({
                        url: SITEURL + "/calenderAjax",
                        type: "POST",
                        data: {
                            id: eventId.value,
                            type: 'delete'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Refresh calendar
                                calendar.refetchEvents();
                                // Hide modal
                                eventModal.hide();
                                // Show success message
                                displayMessage('Kegiatan berhasil dihapus');
                            } else {
                                // Show error message
                                displayMessage('Gagal menghapus kegiatan: ' + (response.message || 'Silakan coba lagi'), 'error');
                            }
                        },
                        error: function() {
                            displayMessage('Terjadi kesalahan saat menghapus kegiatan', 'error');
                        }
                    });
                }
            });

            // Show/hide delete button based on whether this is a new or existing event
            $('#eventModal').on('show.bs.modal', function() {
                if (eventId.value) {
                    $('#deleteEvent').show();
                } else {
                    $('#deleteEvent').hide();
                }
            });
        });

        function updateEvent(eventData) {
            var SITEURL = "{{ url('/') }}";

            $.ajax({
                url: SITEURL + "/calenderAjax",
                type: "POST",
                data: {
                    id: eventData.id,
                    title: eventData.title,
                    start: eventData.start,
                    end: eventData.end,
                    type: 'update'
                },
                success: function(response) {
                    if (!response.success) {
                        // Revert the event if update failed
                        calendar.refetchEvents();
                        displayMessage('Gagal memperbarui kegiatan: ' + (response.message || 'Silakan coba lagi'), 'error');
                    }
                },
                error: function() {
                    // Revert the event on error
                    calendar.refetchEvents();
                    displayMessage('Terjadi kesalahan saat memperbarui kegiatan', 'error');
                }
            });
        }

        function displayMessage(message, type = 'success') {
            toastr[type](message, type === 'error' ? 'Error' : 'Sukses');
        }
    </script>
@endpush
