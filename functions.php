<?php
#
# Find Monday - prints out the previous monday.
# Scott Hurring - scott at hurring dot com
#
function get_monday($startdate = null, $week_offset = 0) {
  if ($startdate) {
    $startdate = strtotime($startdate);
  } else {
    $startdate = time();
  }

  $dow = date("w", $startdate);
  //print "Today is dow $dow (Monday is 1)\n";
  
  // How many days ago was monday?
  $offset = ($dow -1);
  if ($offset <0) {
      $offset = 6;
  }
  //print "Offset = $offset\n";
    
  if ($week_offset > 0) {
    $offset = $offset - ($week_offset * 7);
  }

  $monday = date("Y-m-d", mktime(0,0,0,date('m', $startdate), date('d', $startdate)-$offset, date('Y', $startdate) ));
  
  //print "Previous monday is $monday";
  
  return $monday;
}


#
# Get mondays
#
function get_mondays($startdate = null) {
  $mondays = Array();
  
  for ($i = 0; $i < NUM_WEEKS; $i++) {
    array_push($mondays, get_monday($startdate, $i));
  }

  return $mondays;
}
function setup_mondays() {
  /*if(isset($_GET['startdate'])) {
    $mondays = get_mondays($_GET['startdate']);
  } else {
    $lastweek = date("Y-m-d", mktime(0,0,0,date('m'), date('d')-7, date('Y') ));
    //get calendar starting with previous week
    $mondays = get_mondays($lastweek);
  }
  */
  $mondays = get_mondays(START_DATE);
  
  return $mondays;
}
 
#
# Is this week the current week?
# 
function week_class($monday) {
  $class = '';
  
  $this_monday = get_monday();
  
  if ($monday ==  $this_monday) {
    $class = 'currentweek';
  } elseif ($monday < $this_monday) {
    $class = 'past';
  }
  
  
  
  return $class;
}


#
# Display person name (and link)
#
function the_person_link($person) {
    $link = '<a class="person person-'.$person['person_role'].'" href="person.php" target="_blank">'.$person['person_name'].'</a>';
  
  echo $link;
}

#
# Print table rows for each project/person/week
#
function display_planning_rows($people) {
  $mondays = setup_mondays();	
  
  foreach ($people as $key=>$person) :
  
  ?>
    <tr id="person-<?php echo $person['person_id'] ?>" staffy:person_id="<?php echo $person['person_id'] ?>">
      <!--
      <th class="person-name">
        <?php the_person_link($person); ?>
      </th>
      -->
      <?php foreach ($mondays as $key => $monday) : ?>
        <td class="person-<?php echo $person['person_id']?> <?php echo week_class($monday) ?>" id="cell-<?php echo $person['person_id']?>-<?php echo $monday?>" staffy:person_id="<?php echo $person['person_id']?>" staffy:date="<?php echo $monday; ?>">
        
        <input type="text" size="2" class="hours-input" />
        <span class="overall-estimate">(28)</span>

          <div class="batch-dialog" style="display:none">
            <a href="#" class="copy">cp</a>  
            <a href="#" class="move">mv</a> 
            <a href="#" class="delete">rm</a>              
            <a href="#" class="cancel">x</a>
          </div>
        </td>
      <?php endforeach; ?>
      <th style="width: 40px"></th>
    </tr>
    <?php 
    endforeach;
}

?>