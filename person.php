<?php 
/* setup page and load header */
require_once('header.php');
require_once('person.inc.php'); 
?>


<div id="datepicker">
  Scroll to: 
  <form action="#" method="get">
  <input type="text" name="startdate" id="startdate"
    value="<?php if (isset($_GET['startdate'])) echo $_GET['startdate']; ?>"/>
  <?php if (isset($_GET['startdate'])) : ?> (<a href="./plan-ahead.php">clear</a>)<?php endif; ?>
  <noscript>
  <input type="submit" value="Go" />
  </noscript>
  </form>
</div>

<div id="intro">
<h1>{Person Name}</h1>
</div>



<table id="weeks">
  <thead>
    <tr>
    <!--<th></th>-->
    <?php foreach ($mondays as $key => $monday) : ?>
    <th class="<?php echo week_class($monday) ?>" id="<?php echo $monday; ?>">
      <span class="year"><?php echo date('Y', strtotime($monday)); ?></span>
      <?php echo date('M j', strtotime($monday)); ?>
    </th>
    <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
        <?php display_person_rows($projects); ?>
  </tbody>
</table>

<table id="row-labels">
  <tbody>
    <?php foreach ($projects as $key=>$project) : ?>
    <tr id="project-<?php echo $project['project_id'] ?>" staffy:project_id="<?php echo $project['project_id'] ?>">
      <th class="project-name">
        <?php the_project_link($project); ?>
      </th>
    </tr>
    <?php endforeach; ?>
  </tbody>
  
</table>


<?php 
require_once('footer.php'); 
?>