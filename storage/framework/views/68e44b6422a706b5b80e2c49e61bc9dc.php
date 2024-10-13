
<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/locale/fr.js"></script>
   
   
</head>
<body>
    <input type="text" id="search-input" placeholder="Search events...">
    <div id="calendar"></div>

     <!-- Bootstrap CSS -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript Bundle (includes Popper) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    
<script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                locale: 'fr',
                editable: true,
                selectable: true,
                events: '<?php echo e(route("appointments.index")); ?>',
                eventRender: function(event, element) {
                    var searchValue = $('#search-input').val().toLowerCase();
                    if (searchValue && event.title.toLowerCase().indexOf(searchValue) === -1) {
                        element.hide(); // Hide event if it doesn't match search
                    } else {
                        element.show(); // Show event if it matches search
                    }
                },
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    var description = prompt('Event Description:');
                    if (title) {
                        var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
                        var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
                        $.ajax({
                            url: '<?php echo e(route("appointments.store")); ?>',
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                title: title,
                                description: description,
                                start: start,
                                end: end
                            },
                            success: function(data) {
                                calendar.fullCalendar('refetchEvents');
                                $('#addEventModal').modal('hide');
                                $('#eventAddedModal').modal('show');
                            }
                        });
                    }
                },
                eventDrop: function(event, delta) {
                    var start = event.start.format('YYYY-MM-DD HH:mm:ss');
                    var end = event.end ? event.end.format('YYYY-MM-DD HH:mm:ss') : start;
                    $.ajax({
                        url: '<?php echo e(url("appointments")); ?>/' + event.id,
                        type: 'PUT',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            start: start,
                            end: end
                        },
                        success: function(data) {
                            $('#eventUpdatedModal').modal('show');
                        }
                    });
                },
                eventResize: function(event) {
                    var start = event.start.format('YYYY-MM-DD HH:mm:ss');
                    var end = event.end ? event.end.format('YYYY-MM-DD HH:mm:ss') : start;
                    $.ajax({
                        url: '<?php echo e(url("appointments")); ?>/' + event.id,
                        type: 'PUT',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            start: start,
                            end: end
                        },
                        success: function(data) {
                            $('#eventUpdatedModal').modal('show');
                        }
                    });
                },
                eventClick: function(event) {
                    $('#deleteEventModal').modal('show');
                    $('#confirmDeleteBtn').on('click', function() {
                        $.ajax({
                            url: '<?php echo e(url("appointments")); ?>/' + event.id,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#deleteEventModal').modal('hide');
                                $('#eventDeletedModal').modal('show');
                                calendar.fullCalendar('removeEvents', event.id);
                            }
                        });
                    });
                }
            });

            // Search functionality
            $('#search-input').on('input', function() {
                var searchValue = $(this).val().toLowerCase();
                $('#calendar').fullCalendar('rerenderEvents');
            });
        });
    </script>

    <!-- Modals -->
    <div class="modal fade" id="eventAddedModal" tabindex="-1" aria-labelledby="eventAddedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventAddedModalLabel">Event Added</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Event added successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventUpdatedModal" tabindex="-1" aria-labelledby="eventUpdatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventUpdatedModalLabel">Event Updated</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Event updated successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventDeletedModal" tabindex="-1" aria-labelledby="eventDeletedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDeletedModalLabel">Event Deleted</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Event deleted successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH /home/zak/Desktop/zak tuto dev/laravel tuto/save data/medic-app/resources/views/templates/appointments/index.blade.php ENDPATH**/ ?>