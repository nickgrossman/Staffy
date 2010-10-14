<?php
require_once('functions.php');
require_once('config.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head profile="http://gmpg.org/xfn/11">
    <title>Staffy</title>
    <link type="text/css" href="jquery/css/smoothness/jquery-ui-1.7.1.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="jquery/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.7.1.custom.min.js"></script>
    <script type="text/javascript" src="jquery/plugins/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="jquery/plugins/jquery.qtip-1.0.0-rc3.min.js"></script>
    <script type="text/javascript" src="staffy.js?version=a"></script>
    <link href="reset.css" rel="stylesheet" />
    <link href="staffy.css?version=a" rel="stylesheet" />
    
    <script type="text/javascript">
    <?php // Store people and projects in JS for later use ?>
      Staffy.people = {
        <?php foreach ($people as $key=>$person): ?>
          '<?php echo $person['person_id'] ?>': {
            'person_name': '<?php echo $person['person_name']; ?>',
            'person_role': '<?php echo $person['person_role']; ?>'
          }<?php if ($key < sizeof($people) - 1): ?>,<?php endif; ?>
        
        <?php endforeach; ?>
      };
      Staffy.projects = {
        <?php foreach ($projects as $key=>$project): ?>
          '<?php echo $project['project_id'] ?>': {
            'project_name': '<?php echo $project['project_name']; ?>'
          }<?php if ($key < sizeof($projects) -1 ): ?>,<?php endif; ?>
        
        <?php endforeach; ?>     
      };
    </script>
  </head>
  <body>
  <div id="header">
    <p>Hi, my name is Staffy.</p>
    <ul id="nav">
      <li><a href="./">Dashboard</a></li>
      <li><a href="plan.php">Planning view</a></li>
      <li><a href="person.php">Person view</a></li>
      <li><a href="#">Timesheet + priorities</a></li>
    </ul>
  </div>
  <div id="content">
