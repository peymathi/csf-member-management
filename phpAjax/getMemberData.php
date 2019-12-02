<?php
  //include "phpUtil/db_query.php";

  // Ajax call to be used in checkin form that gets a member's data from a given phone number

  if(isset($_POST['Phone']))
  {
    /* DB Con not finished
    $dbcon = new db_query();
    $member = $dbcon->member_check($_POST['Phone']);
    if ($member)
    {
      // TODO Format member to be of json userData format
      $memberJson = array();

      echo $memberJson
    }

    else echo json_encode(array('Exists' => False));
    */

    // NOTE Temporary. Remove when above code is finished
    echo json_encode(array('Exists' => True));
  }
  else echo 'Error';
?>
