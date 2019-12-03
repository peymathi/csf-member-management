<?php
  include "../phpUtil/db_query.php";

  // Ajax call to be used in checkin form that gets a member's data from a given phone number

  if(isset($_POST['Phone']))
  {
    $dbcon = new db_query();
    $member = $dbcon->member_check($_POST['Phone']);
    var_dump($member);
    if ($member)
    {
      //Format member to be of json userData format
      $memberJson = array();
      $memberJson['FirstName'] = $member['FirstName'];
      $memberJson['LastName'] = $member['LastName'];
      $memberJson['Email'] = $member['EmailAddress'];
      $memberJson['Phone'] = $member['PhoneNumber'];
      $memberJson['Major'] = $member['Major'];
      $memberJson['OptEmail'] = $member['OptEmail'];
      $memberJson['OptTexts'] = $member['OptText'];
      $memberID = $member['MemberID'];
      $memberLifeGroups = $dbcon->member_to_life_group_check(null, $memberID);

      if (sizeof($memberLifeGroups) != 0)
      {
        // Get the lifegroup name that is currently active
        foreach($memberLifeGroups as $lifegroup)
        {
          $temp = $dbcon->life_group_check('LifeGroupID', $lifegroup['LifeGroupID']);
          if($temp['LifeGroupActive'] === 1)
          {
            $memberJson['LifeGroup'] = $temp['LifeGroupDay'] . ' ' . $temp['LifeGroupTime'] . ' ' . $temp['LifeGroupLocation'];
            break;
          }
        }
      }
      else $memberJson['LifeGroup'] = 'None';

      if (!isset($memberJson['LifeGroup'])) $memberJson['LifeGroup'] = 'None';

      $memberJson['Status'] = $dbcon->group_check($member['GroupID']);
      $memberJson['Exists'] = True;

      echo json_encode($memberJson);
    }

    else echo json_encode(array('Exists' => False));
  }
  else echo 'Error';
?>
