<?php

// Ajax call to be used in checkin form for when the check in form is finished
// updates the user in the DB

$changingValues = array('FirstName', 'LastName', 'Email', 'Phone', 'Status', 'Major', 'OptEmail', 'OptTexts');

// include '..phpUtil/db_query.php';
if(isset($_POST['Phone']))
{
  /* NOTE: Uncomplete. Uncomment and finish once database transactions are done.
  $memberData = $_POST;
  $dbcon = new db_query();

  // check if we need to create a new member or edit one
  if ($dbcon->member_check($memberData['Phone']))
  {
    $dbcon->member_edit($memberData['FirstName'], $memberData['LastName'], $memberData['Phone'], $memberData['Email'],
     null, $memberData['Major'], $memberData['Status'], null, $memberData['PrayerRequest'], $memberData['OptEmail'], $memberData['OptTexts']);

    // Add member to a lifegroup if needed

    // Add member to night of worship
  }

  else
  {
    $dbcon->member_create($memberData['FirstName'], $memberData['LastName'], $memberData['Phone'], $memberData['Email'],
     null, $memberData['Major'], $memberData['Status'], null, $memberData['PrayerRequest'], $memberData['OptEmail'], $memberData['OptTexts']);

    // Add member to a lifegroup if needed

    // Add member to night of worship

  }
  */
}
else echo 'Error';

?>
