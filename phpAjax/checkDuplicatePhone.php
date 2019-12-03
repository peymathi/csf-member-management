<?php

// Ajax call to check if a phone number entered within checkin page is already taken

//include '..phpUtil/db_query.php';

/* NOTE: Uncomment this once the database transactions are ready
if (isset($_POST['Phone']))
{
  $dbcon = new db_query();
  $member = $dbcon->member_check($_POST['Phone']);
  if ($member) echo json_encode(array("Exists" => True));
  else echo json_encode(array("Exists" => False));
}
else echo 'Error';
*/

// NOTE: Temporary code. Remove once database transactions are ready
echo json_encode(array("Exists" => True));

?>
