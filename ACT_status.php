<?php
/*This is the first test of an ACT plug in install.
  The service will check the ACT config file for proper values such as:
  no defaults, no blanks.  Like actual vaulues.  --jmt67 2018
*/

require('ACT_inspector.php');


$message = testACT_config();

header('Content-Type: application/json', true);
echo $message;
?>



