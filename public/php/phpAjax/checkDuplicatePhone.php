<?php

// Ajax call to check if a phone number entered within checkin page is already taken

include '../phpUtil/db_query.php';


if (isset($_POST['Phone']))
{
  $dbcon = new db_query();
  $member = $dbcon->member_check($_POST['Phone']);
  if ($member) echo json_encode(array("Exists" => True));
  else echo json_encode(array("Exists" => False));
}
else echo 'Error';

?>
