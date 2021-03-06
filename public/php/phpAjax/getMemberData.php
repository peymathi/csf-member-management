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
      $memberJson['FirstName'] = $member['first_name'];
      $memberJson['LastName'] = $member['last_name'];
      if($member['email'] != null) $memberJson['Email'] = $member['email'];
      else $memberJson['Email'] = 'None';
      $memberJson['Phone'] = $member['phone_number'];
      if($member['Major'] != 'NULL') $memberJson['Major'] = $member['major'];
      else $memberJson['Major'] = 'None';
      $memberJson['OptEmail'] = $member['opt_email'];
      $memberJson['OptTexts'] = $member['opt_text'];
      $memberID = $member['id'];
      $memberLifeGroups = $dbcon->member_to_life_group_check($memberID);

      if ($memberLifeGroups)
      {
        // Get the lifegroup name that is currently active
        foreach($memberLifeGroups as $lifegroup)
        {
          $temp = $dbcon->life_group_check('id', $lifegroup['LifeGroupID']);
          if($temp[0]['life_group_active'])
          {
            $memberJson['LifeGroup'] = $temp[0]['life_group_name'];
            break;
          }
        }
      }
      else $memberJson['LifeGroup'] = 'None';

      if (!isset($memberJson['LifeGroup'])) $memberJson['LifeGroup'] = 'None';

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
