



<!DOCTYPE html>
<html>
<head>
    <title>Calendrier </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/locale/fr.js"></script>
   
   
</head>
<body style="background-color:rgba(152, 196, 220, 0.8)">
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('patients') }}">Retour</a>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search"  id="search-input"  placeholder="Rechercher Par Titre ..." placeholder="Search" aria-label="Search">
      
    </form>
  </div>
</nav>
       
        <br>
        
        <br>
        <div id="calendar-container" style="margin-top:10px;background-color:#304A88"> 
            <div id="calendar"></div>
        </div>

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
                events: '{{ route("appointments.index") }}',
                eventRender: function(event, element) {
                    var searchValue = $('#search-input').val().toLowerCase();
                    if (searchValue && event.title.toLowerCase().indexOf(searchValue) === -1) {
                        element.hide(); // Hide event if it doesn't match search
                    } else {
                        element.show(); // Show event if it matches search
                    }
                },
                /*select: function(start, end, allDay) {
                    $('#addEventModal').modal('show');
                    $('#saveEventBtn').off('click').on('click', function() {
                        var title = $('#eventTitle').val();
                        var description = $('#eventDescription').val();
                        if (title) {
                           // var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
                           // var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
                           
                            $.ajax({
                                url: '{{ route("appointments.store") }}',
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
                    });
                },**/
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    var description = prompt('Event Description:');
                    if (title) {
                        var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
                        var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
                        $.ajax({
                            url: '{{ route("appointments.store") }}',
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
                        url: '{{ url("appointments") }}/' + event.id,
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
                        url: '{{ url("appointments") }}/' + event.id,
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
                    $('#confirmDeleteBtn').off('click').on('click', function() {
                        $.ajax({
                            url: '{{ url("appointments") }}/' + event.id,
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

 <!-- Add Event Modal -->
 <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Ajouter un évènement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="eventTitle">
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="eventDescription"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="eventAddedModal" tabindex="-1" aria-labelledby="eventAddedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventAddedModalLabel">Evénement Ajouté</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Rendez-Vous Ajouté Avec Succés.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventUpdatedModal" tabindex="-1" aria-labelledby="eventUpdatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventUpdatedModalLabel">Evénement Modifié</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Rendez-Vous Modifié Avec Succés.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventDeletedModal" tabindex="-1" aria-labelledby="eventDeletedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDeletedModalLabel">Evénement Supprimé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Rendez-Vous Supprimé Avec Succés.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel">Evénement Supprimé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet événement ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimé</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #calendar-container {
            display: flex;
            justify-content: center;
        }
        #calendar {
            width: 1100px;
        }
    </style>

</body>
</html>
