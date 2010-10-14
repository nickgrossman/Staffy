/*
# jQuery JS for Staffy
# 
#
#
*/


/*
#
# what to do on page load
#
*/
$(document).ready(applyBehaviors);
$(document).ready(scrollToToday);


/* Globals we will want to track */
var Staffy = {};
Staffy.cell;


/*
#
# Apply behaviors to elements on the page
#
*/
function applyBehaviors() {

  $('.actual-hours').qtip({
    content: 'These are my notes',
    show: 'mouseover',
    hide: 'mouseout',
    position: {
      corner:  {
        target: 'topMiddle',
        tooltip: 'bottomMiddle'
      }
    },
    style: {
        name: 'cream',
        tip: 'bottomMiddle'
      }
  });
      
  $('.hours-input').keyup(updateTime);
  
  $('#add-person-to-project').change(addPersonToProject);
  
  $("#startdate").datepicker({ 
    dateFormat: 'yy-mm-dd',
    onSelect: getMondayAndScroll
  });
}

function showNotesDialog(e) {
  var link = $(this);
  var id = 'note-' + this.getAttribute('staffy:person-week');
  
  var dialog = $('#'+id);
  console.log('#'+id);
  
  $(dialog).dialog('open');
  return false;
}

function getMondayAndScroll(dateString) {
  var mondayString; // what we want to find out
  var date = new Date(dateString);
    
  if (date.getDay() != 0) {
    // this is not a monday
    // find out what day it is and then 
    // find the preceding monday
    var dateOffset = (24*60*60*1000) * (date.getDay() - 1);
    date.setTime(date.getTime() - dateOffset);
  }
  
  mondayString = $.datepicker.formatDate('yy-mm-dd', date);  
  
  $.scrollTo(
    '#' + mondayString,
    {
      axis: 'x',
      offset: -165
    }
  );
}

function scrollToToday() {
  getMondayAndScroll($.datepicker.formatDate('yy-mm-dd', new Date()));
}


/*
#
# Updating someone's hours on the planning sheet
#
*/
function updateTime(e) {
  // keeping these values in the Staffy global is a weird hack
  // but my JS is not slick enough to do otherwise
  Staffy.activeCell = $(this).parent();
  Staffy.personId = Staffy.activeCell[0].getAttribute('staffy:person_id'); 
  Staffy.startDate = Staffy.activeCell[0].getAttribute('staffy:date');
  Staffy.entryId = Staffy.activeCell[0].getAttribute('staffy:entry_id'); 
  Staffy.projectId = Staffy.activeCell[0].getAttribute('staffy:project_id');
  Staffy.hours = this.value;
    
  //if( ! Staffy.updateIsHappening) {
  // FIXME: wait after the first keyup, so as not to fire two requests
  // with double-digit numbers
    $.ajax({
      'url': './',
      'type': 'post', 
      'data': {
        'action': 'create', 
        'person_id': Staffy.personId,
        'startdate': Staffy.startDate,
        'project_id': Staffy.projectId,
        'hours': Staffy.hours
      },
      'success': updateTimeResponse
    });
  //}


}

function updateTimeResponse(data, textStatus, request) {
  // this AJAX callback expects:
  // the total number of hours allocated
  // for the given person/project/week
  // ex: 48
  
  // tmp
  if (Staffy.hours == '') Staffy.hours = 0;
  data = parseInt(Staffy.hours) + 28;
  
  var target = $(Staffy.activeCell.children('.estimated-hours')[0]);
  target.empty().prepend(data);

}


/*
#
# Add a new person row to the project table
#
*/
function addPersonToProject(e) {
  if (this.value != '') {
  
    var namesRow = $('table#weeks tbody tr:last');
    var hoursRow = $('table#row-labels tbody tr:last');
    var personId = this.value;
    
    namesRow.clone().insertAfter(namesRow);
    hoursRow.clone().insertAfter(hoursRow);
  }
}

