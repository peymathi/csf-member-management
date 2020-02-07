<?php
session_start();

// Ajax call to be used in checkin form for when the check in form is finished
// updates the user in the DB

include '../phpUtil/db_query.php';
if(isset($_POST['json']))
{
  $memberData = json_decode($_POST['json'], true);

  $dbcon = new db_query();

  // If the member already exists
  if ($dbcon->member_check($memberData['Phone']))
  {
    $status = $dbcon->get_group_id($memberData['Status']);
    $dbcon->member_edit($memberData['Phone'], $memberData['FirstName'], $memberData['LastName'], $memberData['Phone'], $memberData['Email'],
     null, $memberData['Major'], null, $memberData['PrayerRequest'], $memberData['OptEmail'], $memberData['OptTexts'], $status);

    // Add member to night of worship
    $nowID = ($dbcon->NOW_check($_SESSION['checkinDate']))['NightID'];
    $memberID = ($dbcon->member_check($memberData['Phone']))['MemberID'];
    $dbcon->member_to_NOW_create($memberID, $nowID);

    // Add member to life group if needed
    # Gets the list of all lifegroups the member has been in
    $lifegroups = $dbcon->member_to_life_group_check($memberID);


    // NOTE NEEDS REWORKED. WILL CURRENTLY CREATE DUPLICATE ENTRIES
    // IN MEMBER-LIFEGROUP JUNCTION UNDER CERTAIN CIRCUMSTANCES
    echo $memberData['LifeGroup'];
    if($memberData['LifeGroup'] != "None")
    {
      # Find out if the user is in a currently active lifegroup
      if($lifegroups)
      {
        $lifegroupActive = "None";
        foreach($lifegroups as $lifegroup)
        {
          $lgID = $lifegroup['LifeGroupID'];
          $lg = $dbcon->life_group_check("LifeGroupID", $lgID);
          if($lg[0]['LifeGroupActive']) $lifegroupActive = $lg[0];
        }

        // Check if the life group selected matches their current group
        if($lifegroupActive != "None")
        {
          // Member signed up for a new life group, need to add that to db
          if($lifegroupActive['LifeGroupName'] != $memberData['LifeGroup'])
          {
            $lg = $dbcon->life_group_check("LifeGroupName", $memberData['LifeGroup']);
            $dbcon->member_to_life_group_create($memberID, $lg[0]['LifeGroupID']);
          }
        }
        else
        {
          $lg = $dbcon->life_group_check("LifeGroupName", $memberData['LifeGroup']);
          $dbcon->member_to_life_group_create($memberID, $lg[0]['LifeGroupID']);
        }
      }
      else
      {
        $lg = $dbcon->life_group_check("LifeGroupName", $memberData['LifeGroup']);
        $dbcon->member_to_life_group_create($memberID, $lg[0]['LifeGroupID']);
      }
    } // NOTE END REWORK

    echo 'Success';
  }

  // Member does not exist yet, need to make new member
  else
  {
    $args['FirstName'] = $memberData['FirstName'];
    $args['LastName'] = $memberData['LastName'];
    $args['PhoneNumer'] = $memberData['Phone'];
    $args['Email'] = $memberData['Email'];
    $args['Major'] = $memberData['Major'];
    $args['PrayerRequest'] = $memberData['PrayerRequest'];
    $args['OptEmail'] = $memberData['OptEmail'];
    $args['OptTexts'] = $memberData['OptTexts'];
    $args['GroupID'] = $dbcon->get_group_id($memberData['Status']);

    $dbcon->member_create($args);

     // Add member to night of worship
     $nowID = ($dbcon->NOW_check($_SESSION['checkinDate']))['night_id'];
     $memberID = ($dbcon->member_check($args['PhoneNumber']))['member_id'];
     $dbcon->member_to_NOW_create($memberID, $nowID);

    // Add member to a lifegroup if needed
    if($memberData['LifeGroup'] != "None")
    {
      $lg = $dbcon->life_group_check("LifeGroupName", $memberData['LifeGroup']);
      $dbcon->member_to_life_group_create($memberID, $lg[0]['LifeGroupID']);
    }

    #
    # DEBUG
    #
    foreach($memberData as $key => $value)
    {
      error_log('Key: ' . $key . ' => Value: ' . $value . "\n", 3, $_SERVER['DOCUMENT_ROOT'] . "/../debug.log");
    }

    echo 'Success';
  }
}
else echo 'Error';

?>
