<?php

// Ajax call to be used in checkin form for when the check in form is finished
// updates the user in the DB

include '../phpUtil/db_query.php';
if(isset($_POST['json']))
{
  $memberData = json_decode($_POST['json'], true);

  $dbcon = new db_query();

  // check if we need to create a new member or edit one
  if ($dbcon->member_check($memberData['Phone']))
  {
    $status = $dbcon->get_group_id($memberData['Status']);
    $dbcon->member_edit($memberData['Phone'], $memberData['FirstName'], $memberData['LastName'], $memberData['Phone'], $memberData['Email'],
     null, $memberData['Major'], null, $memberData['PrayerRequest'], $memberData['OptEmail'], $memberData['OptTexts'], $status);

    // Add member to a lifegroup if needed

    // Add member to night of worship

    echo json_encode(array('TEST' => 'TEST1'));
  }

  else
  {
    $status = $dbcon->get_group_id($memberData['Status']);
    $dbcon->member_create($memberData['FirstName'], $memberData['LastName'], $memberData['Phone'], $memberData['Email'],
     null, $memberData['Major'], null, $memberData['PrayerRequest'], $memberData['OptEmail'], $memberData['OptTexts'], $status);

    // Add member to a lifegroup if needed

    // Add member to night of worship

    echo json_encode(array('TEST' => 'Test2'));

  }
}
else echo 'Error';

?>
