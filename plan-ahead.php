<?php 
/* setup page and load header */
require_once('header.php');
require_once('plan-ahead.inc.php'); 
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
<h1>MTA Bus CIS - Planning view</h1>
</div>



<table id="weeks">
  <thead>
    <tr>
    <!--<th></th>-->
    <?php foreach ($mondays as $key => $monday) : ?>
    <th class="<?php echo week_class($monday) ?>" id="<?php echo $mondays[$key+2]; ?>"><?php echo date('M j', strtotime($monday)); ?><br /><?php echo date('Y', strtotime($monday)); ?></th>
    <?php endforeach; ?>
    <th></th>
    </tr>
  </thead>
  <tbody>
        <?php display_planning_rows($people); ?>
  </tbody>
</table>

<table id="row-labels">
  <tbody>
    <?php foreach ($people as $key=>$person) : ?>
    <tr id="person-<?php echo $person['person_id'] ?>" staffy:person_id="<?php echo $person['person_id'] ?>">
      <th class="person-name">
        <?php the_person_link($person); ?>
      </th>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td>
        <select id="add-person-to-project">
          <option value="">Add a person</option>
          <?php foreach ($people as $key => $person) : ?>
          <option value="<?php echo $person['person_id']; ?>"><?php echo $person['person_name']; ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr> 
  </tfoot>
  
</table>

<!--
<ul class="people">
  <?php foreach ($people as $key => $person) : ?>
    <li class="person source person-<?php echo $person['person_role']?> person-<?php echo $entry['person_id']; ?>" staffy:person_id="<?php echo $person['person_id']?>" title="<?php echo $person['person_long_name']; ?>"><?php echo $person['person_name']; ?></li>
  <?php endforeach; ?>
</ul>
-->


<?php 
require_once('footer.php'); 
?>