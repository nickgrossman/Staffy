<?php
define('NUM_WEEKS', 52);
define('START_DATE', '2010-08-01');

$people = array(
  array(
    'person_id' => '1',
    'person_name' => 'R Marianski',
    'person_long_name' => 'Robert Marianski',
    'person_role' => 'dev'
  ),
array(
    'person_id' => '2',
    'person_name' => 'J Maki',
    'person_long_name' => 'Jeff Maki',
    'person_role' => 'pm'
  ),
array(
    'person_id' => '3',
    'person_name' => 'A Cochran',
    'person_long_name' => 'Andy Cochran',
    'person_role' => 'dzn'
  ),
array(
    'person_id' => '4',
    'person_name' => 'C Patterson',
    'person_long_name' => 'Chris Patterson',
    'person_role' => 'dzn'
  ),
array(
    'person_id' => '5',
    'person_name' => 'D Turner',
    'person_long_name' => 'David Turner',
    'person_role' => 'dev'
  ),
array(
    'person_id' => '6',
    'person_name' => 'Designer',
    'person_long_name' => 'Designer',
    'person_role' => 'dzn'
  ),
array(
    'person_id' => '7',
    'person_name' => 'Developer',
    'person_long_name' => 'Developer',
    'person_role' => 'dev'
  )
);

$projects = array(
  array(
    'project_id' => '1',
    'project_name' => 'DOT Portals',
  ),
  array(
    'project_id' => '2',
    'project_name' => 'MTA Bus CIS',
  ),
  array(
    'project_id' => '1',
    'project_name' => 'Sound Transit',
  )
);

$mondays = setup_mondays();
?>