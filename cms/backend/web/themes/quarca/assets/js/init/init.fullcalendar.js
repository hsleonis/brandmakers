"use strict";
$(document).ready(function() {
/*******************************
EXTERNAL EVENTS
*******************************/
    $('#external-events .event').each(function() {
        $(this).data('event', {
            title: $.trim($(this).text()),
            stick: true
        });
        
        //Draggable events using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0
        });
    });
    
/*******************************
ADD NEW EXTERNAL EVENT
*******************************/   
    $("#add-external-event #submit-event").on('click', function() {
        var eventTitle = $("#eventTitle").val();
        
        var domElement = $("<div class='event btn'>" +eventTitle +"</div>").draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0
        });
        
        domElement.appendTo("#external-events .events")
        
        $(domElement).data('event', {
            title: $.trim($(domElement).text()),
            stick: true
        });
        
        $('#add-event-modal').modal('hide')
        
        $.ajax({
            type: "POST",
            data: eventTitle
        });
        return false;
    });
    
/*******************************
SWITCH - REMOVE AFTER DROP
*******************************/  
    var danger = document.querySelector('.switch-danger');
    var switchery = new Switchery(danger, { color: '#e26a6a' });

/*******************************
CALENDAR
*******************************/
    var calendar = $('#agenda').fullCalendar({
	header: {
	    left: 'month,agendaWeek,agendaDay',
	    center: 'title',
	    right: 'prev,today,next,'
	},
        defaultDate: '2015-02-14',
        defaultView: 'agendaWeek',
	editable: true,
	eventLimit: false,
        selectHelper: true,
        
        //External Events
	droppable: true,
	drop: function() {
            //Remove after drop
            if ($('#drop-remove').is(':checked')) {
                $(this).remove();
            }
	},
        
        //Close
        eventRender: function(event, element) {
            element.append( "<span class='delete'>&times;</span>" );
            element.find(".delete").on('click', function() {
               $('#agenda').fullCalendar('removeEvents',event._id);
            });
        },
        
        //Events
	events: [
            {
                title: 'Team Meeting',
                start: '2015-02-09T08:00:00',
                end: '2015-02-09T09:00:00',
            },
            {
                title: 'Team Meeting',
                start: '2015-02-10T08:00:00',
                end: '2015-02-10T09:00:00',
            },
            {
                title: 'Team Meeting',
                start: '2015-02-11T08:00:00',
                end: '2015-02-11T09:00:00',
            },
            {
                title: 'Team Meeting',
                start: '2015-02-12T08:00:00',
                end: '2015-02-12T09:00:00',
            },
            {
                title: 'Team Meeting',
                start: '2015-02-13T08:00:00',
                end: '2015-02-13T09:00:00',
            },
            
            {
                title: 'Lunch',
                start: '2015-02-09T12:00:00',
                end: '2015-02-09T13:00:00',
            },
            {
                title: 'Lunch with the team',
                start: '2015-02-10T12:00:00',
                end: '2015-02-10T13:00:00',
            },
            {
                title: 'Lunch with potential investor',
                start: '2015-02-11T12:00:00',
                end: '2015-02-11T13:30:00',
            },
            {
                title: 'Private event',
                start: '2015-02-12T12:00:00',
                end: '2015-02-12T14:30:00',
            },
            {
                title: 'Lunch',
                start: '2015-02-13T12:00:00',
                end: '2015-02-13T13:00:00',
            },
            
            {
                title: 'Conference',
                start: '2015-02-09T14:00:00',
                end: '2015-02-09T16:00:00',
            },
            
            {
                title: 'Birthday Party',
                start: '2015-02-08T10:00:00',
                end: '2015-02-08T18:00:00',
            },
            
            {
                title: 'Dinner with friends',
                start: '2015-02-10T20:00:00',
                end: '2015-02-10T23:00:00',
            },
            
            {
                title: 'Dinner with family',
                start: '2015-02-13T20:00:00',
                end: '2015-02-13T22:00:00',
            },
            
            {
                title: 'Visit new houses',
                start: '2015-02-14T09:00:00',
                end: '2015-02-14T12:00:00',
            },
            {
                title: 'Shopping',
                start: '2015-02-14T13:00:00',
                end: '2015-02-14T15:00:00',
            },
            {
                title: 'Dinner',
                start: '2015-02-14T20:00:00',
                end: '2015-02-14T23:00:00',
            },
	],

    })//fullCalendar
});//END