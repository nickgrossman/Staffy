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
  Staffy.containerCell = $(this).parent();
  var personId = Staffy.containerCell[0].getAttribute('staffy:person_id'); 
  var startDate = Staffy.containerCell[0].getAttribute('staffy:date');
  var entryId = Staffy.containerCell[0].getAttribute('staffy:entry_id'); 
  var projectId = Staffy.containerCell[0].getAttribute('staffy:project_id');
  var hours = this.value;
  Staffy.cell = Staffy.containerCell;
    
  // FIXME: wait after the first keyup, so as not to fire two requests
  // with double-digit numbers

  if (!entryId){
    //this is a new entry
    $.post('./', 
      {
      'action': 'create', 
      'person_id': personId,
      'startdate': startDate,
      'project_id': projectId,
      'hours': hours
      },
      updateTimeResponse);
  } else {
    // this is an update
    $.post('./', 
      {
      'action': 'update', 
      'entry_id': entryId,
      'startdate': startDate,
      'project_id': projectId,
      'hours': hours
      }, 
      updateTimeResponse);
  }

}

function updateTimeResponse(data, textStatus) {
  console.log(Staffy.containerCell);
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

