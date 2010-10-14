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
# Display project name (and link)
#
function the_project_link($project) {
    $link = '<a class="project" href="project.php" target="_blank">'.$project['project_name'].'</a>';
  
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
      <?php foreach ($mondays as $key => $monday) : ?>
        <td class="person-<?php echo $person['person_id']?> <?php echo week_class($monday) ?>" id="cell-<?php echo $person['person_id']?>-<?php echo $monday?>" staffy:person_id="<?php echo $person['person_id']?>" staffy:date="<?php echo $monday; ?>">
        <?php if (strtotime(date('Y-m-d')) > strtotime($mondays[$key+1])) : ?>
        <!-- this is a past week -->
        <span class="actual-hours">32</span>
        <span class="estimated-hours">28</span>
        
        <?php else : ?>
        <!-- this is a present or future week -->
        <input type="text" size="2" class="hours-input" />
        <span class="estimated-hours">28</span>
        <?php endif; ?>
        

        </td>
      <?php endforeach; ?>
      <th style="width: 40px"></th>
    </tr>
    <?php 
    endforeach;
}

#
# Print table rows a given person's projects
#
function display_person_rows($projects) {
  $mondays = setup_mondays();	
  
  foreach ($projects as $key=>$project) :
  
  ?>
    <tr id="project-<?php echo $project['project_id'] ?>" staffy:project_id="<?php echo $project_id['project_id'] ?>">

      <?php foreach ($mondays as $key => $monday) : ?>
        <td class="project-<?php echo $project['project_id']?> <?php echo week_class($monday) ?>" id="cell-<?php echo $project['project_id']?>-<?php echo $monday?>" staffy:project_id="<?php echo $project['project_id']?>" staffy:date="<?php echo $monday; ?>">
        
        <?php if (strtotime(date('Y-m-d')) > strtotime($mondays[$key+1])) : ?>
        <!-- this is a past week -->
        <span class="actual-hours">32</span>
        <span class="estimated-hours">28</span>        <?php else : ?>
        <!-- this is a present or future week -->
        <span class="estimated-hours">28</span>
        <?php endif; ?>

        </td>

      <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
  
  <!-- summary row -->
    <tr id="project-<?php echo $project['project_id'] ?>" staffy:project_id="<?php echo $project_id['project_id'] ?>">

      <?php foreach ($mondays as $key => $monday) : ?>
        <td class="project-<?php echo $project['project_id']?> <?php echo week_class($monday) ?> summary" id="cell-<?php echo $project['project_id']?>-<?php echo $monday?>" staffy:project_id="<?php echo $project['project_id']?>" staffy:date="<?php echo $monday; ?>">
        
        <strong>84</strong>              
        </td>
        

      <?php endforeach; ?>
    </tr>

  
<?php
}
?>