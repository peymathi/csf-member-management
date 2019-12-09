<?php
  include "../phpUtil/db_query.php";

  // Ajax call to be used in checkin form that gets a member's data from a given phone number

  if(isset($_POST['Phone']))
  {
    $dbcon = new db_query();
    $member = $dbcon->member_check($_POST['Phone']);
    if ($member)
    {
      //Format member to be of json userData format
      $memberJson = array();
      $memberJson['FirstName'] = $member['FirstName'];
      $memberJson['LastName'] = $member['LastName'];
      if($member['EmailAddress'] != null) $memberJson['Email'] = $member['EmailAddress'];
      else $memberJson['Email'] = 'None';
      $memberJson['Phone'] = $member['PhoneNumber'];
      if($member['Major'] != 'NULL') $memberJson['Major'] = $member['Major'];
      else $memberJson['Major'] = 'None';
      $memberJson['OptEmail'] = $member['OptEmail'];
      $memberJson['OptTexts'] = $member['OptText'];
      $memberID = $member['MemberID'];
      $memberLifeGroups = $dbcon->member_to_life_group_check($memberID);

      if ($memberLifeGroups)
      {
        // Get the lifegroup name that is currently active
        foreach($memberLifeGroups as $lifegroup)
        {
          $temp = $dbcon->life_group_check('LifeGroupID', $lifegroup['LifeGroupID']);
          if($temp[0]['LifeGroupActive'])
          {
            $memberJson['LifeGroup'] = $temp[0]['LifeGroupName'];
            break;
          }
        }
      }
      else $memberJson['LifeGroup'] = '2';

      if (!isset($memberJson['LifeGroup'])) $memberJson['LifeGroup'] = '1';

      $memberJson['Status'] = $dbcon->group_check($member['GroupID']);
      $memberJson['Exists'] = True;

      //Header("Content-Type: application/json", true);
      echo json_encode($memberJson);
    }

    else
    {
      //Header("Content-Type: application/json", true);
      echo json_encode(array('Exists' => False));
    }
  }
  else echo 'Error';
?>
