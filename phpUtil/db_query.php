<?php
/*
* db_query.php
* Corey Stockton
*
* This file contains a class that acts as an interface for interacting with the
* database. When queueing data, the data is stored in the database. Upon
* success, nothing is returned. Exceptions will be thrown when an error occurs.
*
* Constructors:
*   db_query()
*
* Methods:
*   admin_check(string $email, string $password)
*   admin_create(string $fname, string $lname, string $email, string $password)
*   admin_edit(string $field, string $equals, $fname=null, $lname=null,
        $email=null, $password=null)
*   admin_remove(string $field, string $equals)
*
*   group_check($groupID)
*   group_create(string $name)
*   TODO: group_edit()
*   group_remove(string $field, string $equals)
*
*   life_group_check(string $field, string $equals)
*   life_group_create(string $name, string $day, string $time, string $location)
*   life_group_edit(string $field, string $equals, $name=null, $day=null,
        $time=null, $location=null)
*   life_group_remove(string $field, string $equals)
*
*   member_check(string $number)
*   member_create(string $fname, string $lname, string $number, $email=null,
        $address=null, $major=null, $photoPath=null, $prayerR=null, $optE="0",
        $optT="0")
*   member_edit(string $number, $fname=null, $lname=null, $numberN=null,
        $email=null, $address=null, $major=null, $photoPath=null, $prayerR=null,
        $optE=null, $optT=null)
*   member_remove(string $number)
*
*   member_to_life_group_check($memberID=null, $life_groupID=null)
*   member_to_life_group_create($memberID, $life_groupID)
*   TODO: member_to_life_group_edit()
*   member_to_life_group_remove($memberID, $life_groupID)
*
*   member_to_NOW_check($memberID=null, $NOWID=null)
*   member_to_NOW_create($memberID, $NOWID)
*   TODO: member_to_NOW_edit()
*   TODO: member_to_NOW_remove()
*
*   NOW_check(string $date)
*   NOW_create(string $date)
*   NOW_edit(string $dateOld, string $dateNew)
*   NOW_remove(string $date)
*
*   get_prayer_requests()
*   get_contact_emails()
*   get_contact_texts()
*   TODO: get_members_in_lifeGroups()
*   get_members_not_in_lifeGroups()
*   get_member_addresses()
*
*
*
*/
include 'db_connect.php';

class db_query
{
  //
  // Properties
  //
  private $connection;
  private $query;

  //
  // consructor
  //
  function __construct()
  {
    // Set queue variable to an empty string
    $this -> query = "";

    // Setup the connection with the database
    try
    {
      $this -> connection = db_connect();
    }
    catch(Exception $e)
    {
      echo "Caught exception: ",  $e->getMessage(), "\n";
    }
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  //  admins
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // admin_check
  //
  public function admin_check(string $email, string $password)
  {
    //
    // Check if the user exists and entered correct login data, then returns
    // array of result if found, or false
    //
    $stmt = $this -> connection -> prepare("SELECT * FROM admins WHERE email = ? AND password = ?");

    $stmt -> bindParam(1, $email);
    $stmt -> bindParam(2, $password);

    $stmt -> execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result != null)
    {
      if(count($result) != 0) // not empty
      {
        return $result;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  //
  // admin_create
  //
  public function admin_create(string $fname, string $lname, string $email, string $password)
  {
    // Takes the first name, last name, email, and password and stores them in the
    // database.
    $stmt = $this -> connection -> prepare("INSERT INTO admins (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");

    $stmt -> bindParam(1, $fname);
    $stmt -> bindParam(2, $lname);
    $stmt -> bindParam(3, $email);
    $stmt -> bindParam(4, $password);

    $stmt -> execute();
  }

  //
  // admin_edit
  //
  public function admin_edit(string $field, string $equals, $fname=null, $lname=null, $email=null, $password=null)
  {
    // Takes the number of the member to find in the DB.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
    $query = "UPDATE admins SET firstname = ";
    if($fname != null)
    {
      $query .= "'" . $fname . "',";
    }
    else
    {
      $query .= "firstname, ";
    }
    $query .= "lastname = ";
    if($lname != null)
    {
      $query .= "'" . $lname . "', ";
    }
    else
    {
      $query .= "lastname, ";
    }
    $query .= "email = ";
    if($email != null)
    {
      $query .= "'" . $email . "', ";
    }
    else
    {
      $query .= "email, ";
    }
    $query .= "password = ";
    if($password != null)
    {
      $query .= "'" . $password . "' ";
    }
    else
    {
      $query .= "password ";
    }
    $query .= "WHERE " . $field . " = '" . $equals . "' ";
    //echo $query;
    $stmt = $this -> connection -> prepare($query);
    $stmt -> execute();
  }

  //
  // admin_remove
  //
  public function admin_remove(string $field, string $equals)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    $stmt = $this -> connection -> prepare("DELETE FROM admins WHERE " . $field . " = '" . $equals . "'");
    //echo "DELETE FROM admins WHERE " . $field . " = '" . $equals . "'";
    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // group
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // group_check
  //
  public function group_check($groupID)
  {
    $stmt = $this -> connection -> prepare("SELECT GroupName FROM groups WHERE GroupID = ?");

    $stmt -> bindParam(1, $groupID);

    $stmt -> execute();

    return ($stmt -> fetch(PDO::FETCH_ASSOC))['GroupName'];
  }

  //
  // group_create
  //
  public function group_create(string $name)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO groups (GroupName) VALUES (?)");

    $stmt -> bindParam(1, $name);

    $stmt -> execute();
  }

  //
  // group_edit
  //
  public function group_edit()
  {

  }

  //
  // group_remove
  //
  public function group_remove(string $field, string $equals)
  {
    $stmt = $this -> connection -> prepare("DELETE FROM group WHERE " + $field + " = " + $equals);

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // life_group
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // life_group_check
  //
  public function life_group_check(string $field, string $equals)
  {
    $stmt = $this -> connection -> prepare("SELECT * FROM life_groups WHERE " . $field . " = '" . $equals . "'");

    $stmt -> execute();

    return $stmt -> fetch(PDO::FETCH_ASSOC);
  }

  //
  // life_group_create
  //
  // NOTE: day can only be 9 chars at max and time in HH:MM:SS 24hr format
  public function life_group_create(string $name, string $day, string $time, string $location)
  {
    // Takes the name of the life group, the weekly day of the meeting, the time
    // at the meeting, and a description of the meeting.
    $stmt = $this -> connection -> prepare("INSERT INTO life_groups (LifeGroupName, LifeGroupDay, LifeGroupTime, LifeGroupLocation) VALUES (?, ?, ?, ?)");

    $stmt -> bindParam(1, $name);
    $stmt -> bindParam(2, $day);
    $stmt -> bindParam(3, $time);
    $stmt -> bindParam(4, $location);

    $stmt -> debugDumpParams();

    $stmt -> execute();
  }

  //
  // life_group_edit
  //
  public function life_group_edit(string $field, string $equals, $name=null, $day=null, $time=null, $location=null)
  {
    // Takes the field of concern and what it should be looking for in the field.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
    $query = "UPDATE life_groups SET LifeGroupName = ";
    if($name != null)
    {
      $query .= "'" . $name . "',";
    }
    else
    {
      $query .= "LifeGroupName, ";
    }
    $query .= "LifeGroupDay = ";
    if($day != null)
    {
      $query .= "'" . $day . "', ";
    }
    else
    {
      $query .= "LifeGroupDay, ";
    }
    $query .= "LifeGroupTime = ";
    if($time != null)
    {
      $query .= "'" . $time . "', ";
    }
    else
    {
      $query .= "LifeGroupTime, ";
    }
    $query .= "LifeGroupLocation = ";
    if($location != null)
    {
      $query .= "'" . $location . "' ";
    }
    else
    {
      $query .= "LifeGroupLocation ";
    }
    $query .= "WHERE " . $field . " = '" . $equals . "' ";
    //echo $query;
    $stmt = $this -> connection -> prepare($query);
    $stmt -> execute();
  }

  //
  // life_group_remove
  //
  public function life_group_remove(string $field, string $equals)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    $stmt = $this -> connection -> prepare("DELETE FROM life_groups WHERE " . $field . " = '" . $equals . "' ");

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // member
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // member_check
  //
  public function member_check(string $number)
  {
    // NOTE @COREY: Make this function return some kind of datatype with all of the
    // member's data in it. or false if no such member exists for the number
    $stmt = $this -> connection -> prepare("SELECT * FROM members WHERE PhoneNumber = ?");

    $stmt -> bindParam(1, $number);

    $stmt -> execute(array($number));

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    if($result != null) // not empty
    {
      if(count($result) != 0) // not empty
      {
        return $result;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  //
  // member_create
  //
  public function member_create(string $fname, string $lname, string $number, $email=null, $address=null, $major=null, $photoPath=null, $prayerR=null, $optE="0", $optT="0")
  {
    // Creates a new member taking the first and last name with their number.
    $stmt = $this -> connection -> prepare("INSERT INTO members (FirstName,LastName,EmailAddress,HomeAddress,Major,PhoneNumber,PhotoPath,PrayerRequest,OptEmail,OptText) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if($email == null)
    {
      $email = "NULL";
    }
    if($address == null)
    {
      $address = "NULL";
    }
    if($major == null)
    {
      $major = "NULL";
    }
    if($photoPath == null)
    {
      $photoPath = "NULL";
    }
    if($prayerR == null)
    {
      $prayerR = "NULL";
    }
    if($optE == null)
    {
      $optE = "0";
    }
    if($optT == null)
    {
      $optT = "0";
    }

    $stmt -> bindParam(1,$fname);
    $stmt -> bindParam(2,$lname);
    $stmt -> bindParam(3,$email);
    $stmt -> bindParam(4,$address);
    $stmt -> bindParam(5,$major);
    $stmt -> bindParam(6,$number);
    $stmt -> bindParam(7,$photoPath);
    $stmt -> bindParam(8,$prayerR);
    $stmt -> bindParam(9,$optE);
    $stmt -> bindParam(10,$optT);

    //$stmt -> debugDumpParams();

    $stmt -> execute();
  }


  public function member_edit(string $number, $fname=null, $lname=null, $numberN=null, $email=null, $address=null, $major=null, $photoPath=null, $prayerR=null, $optE=null, $optT=null)
  {
    // Takes the number of the member to find in the db.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
    // Start + FirstName
    $query = "UPDATE members SET FirstName = ";
    if($fname != null)
    {
      $query .= "'" . $fname . "',";
    }
    else
    {
      $query .= "FirstName, ";
    }
    // LastName
    $query .= "LastName = ";
    if($lname != null)
    {
      $query .= "'" . $lname . "', ";
    }
    else
    {
      $query .= "LastName, ";
    }
    // PhoneNumber
    $query .= "PhoneNumber = ";
    if($numberN != null)
    {
      $query .= "'" . $numberN . "', ";
    }
    else
    {
      $query .= "PhoneNumber, ";
    }
    // EmailAddress
    $query .= "EmailAddress = ";
    if($email != null)
    {
      $query .= "'" . $email . "', ";
    }
    else
    {
      $query .= "EmailAddress, ";
    }
    // HomeAddress
    $query .= "HomeAddress = ";
    if($address != null)
    {
      $query .= "'" . $address . "', ";
    }
    else
    {
      $query .= "HomeAddress, ";
    }
    // Major
    $query .= "Major = ";
    if($major != null)
    {
      $query .= "'" . $major . "', ";
    }
    else
    {
      $query .= "Major, ";
    }
    // PhotoPath
    $query .= "PhotoPath = ";
    if($photoPath != null)
    {
      $query .= "'" . $photoPath . "', ";
    }
    else
    {
      $query .= "PhotoPath, ";
    }
    // PrayerRequest
    $query .= "PrayerRequest = ";
    if($prayerR != null)
    {
      $query .= "'" . $prayerR . "', ";
    }
    else
    {
      $query .= "PrayerRequest, ";
    }
    // OptEmail
    $query .= "OptEmail = ";
    if($optE != null)
    {
      $query .= "'" . $optE . "', ";
    }
    else
    {
      $query .= "OptEmail, ";
    }
    // OptText
    $query .= "OptText = ";
    if($optT != null)
    {
      $query .= "'" . $optT . "' ";
    }
    else
    {
      $query .= "OptText ";
    }

    $query .= "WHERE PhoneNumber = '" . $number . "' ";
    //echo $query;
    $stmt = $this -> connection -> prepare($query);
    $stmt -> execute();
  }

  //
  // member_remove
  //
  public function member_remove(string $number)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    $stmt = $this -> connection -> prepare("DELETE FROM members WHERE PhoneNumber = ?");

    $stmt -> bindParam(1, $number);

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // NOW
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // NOW_check
  //
  public function NOW_check(string $date)
  {
    $stmt = $this -> connection -> prepare("SELECT * FROM nights_of_worship WHERE NightDate = ?");

    $stmt -> bindParam(1, $date);

    $stmt -> execute();

    return $stmt -> fetch(PDO::FETCH_ASSOC);
  }
  //
  // NOW_create
  //
  public function NOW_create(string $date)
  {
    // Expects dates to be in the YYYY-MM-DD format
    $stmt = $this -> connection -> prepare("INSERT INTO nights_of_worship (NightDate) VALUES (?)");

    $stmt -> bindParam(1, $date);

    $stmt -> execute();
  }

  //
  // NOW_edit
  //
  public function NOW_edit(string $dateOld, string $dateNew)
  {
    $stmt = $this -> connection -> prepare("UPDATE nights_of_worship SET NightDate = ? WHERE NightDate = ?");

    $stmt -> bindParam(1, $dateNew);
    $stmt -> bindParam(2, $dateOld);

    $stmt -> execute();
  }

  //
  // NOW_remove
  //
  public function NOW_remove(string $date)
  {
    $stmt = $this -> connection -> prepare("DELETE FROM nights_of_worship WHERE NightDate = ?");

    $stmt -> bindParam(1, $date);

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // member_to_life_group
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // member_to_life_group_check
  //
  public function member_to_life_group_check($memberID=null, $life_groupID=null)
  {

    $query = "SELECT * FROM member_life_group_junction WHERE ";
    // MemberID
    $query .= "MemberID = ";
    if($memberID != null)
    {
      $query .= "'" . $memberID . "', ";
    }
    else
    {
      $query .= "MemberID, ";
    }
    // LifeGroupID
    $query .= "LifeGroupID = ";
    if($life_groupID != null)
    {
      $query .= "'" . $life_groupID . "' ";
    }
    else
    {
      $query .= "LifeGroupID ";
    }

    $stmt = $this -> connection -> prepare($query);

    $stmt -> execute();

    return $stmt -> fetchAll(PDO::FETCH_ASSOC);
  }

  //
  // member_to_life_group_create
  //
  public function member_to_life_group_create($memberID, $life_groupID)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO member_life_group_junction (MemberID, LifeGroupID) VALUE (?, ?)");

    $stmt -> bindParam(1, $memberID);
    $stmt -> bindParam(2, $life_groupID);

    $stmt -> execute();
  }

  //
  // member_to_life_group_edit
  //
  public function member_to_life_group_edit()
  {

  }

  //
  // member_to_life_group_remove
  //
  public function member_to_life_group_remove($memberID, $life_groupID)
  {
    $stmt = $this -> connection -> prepare("DELETE FROM member_life_group_junction WHERE MemberID = ? AND LifeGroupID = ?");

    $stmt -> bindParam(1, $memberID);
    $stmt -> bindParam(2, $life_groupID);

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // member_to_NOW
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // member_to_NOW_check
  //
  public function member_to_NOW_check($memberID=null, $NOWID=null)
  {
    $query = "SELECT * FROM member_nights_of_worship_junction WHERE ";
    // MemberID
    $query .= "MemberID = ";
    if($memberID != null)
    {
      $query .= "'" . $memberID . "', ";
    }
    else
    {
      $query .= "MemberID, ";
    }
    // LifeGroupID
    $query .= "NightID = ";
    if($NOWID != null)
    {
      $query .= "'" . $NOWID . "' ";
    }
    else
    {
      $query .= "NightID ";
    }

    $stmt = $this -> connection -> prepare($query);

    $stmt -> execute();

    return $stmt -> fetchAll(PDO::FETCH_ASSOC);
  }

  //
  // member_to_NOW_create
  //
  public function member_to_NOW_create($memberID, $NOWID)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO member_nights_of_worship_junction (MemberID, NightID) VALUES (?, ?)");

    $stmt -> bindParam(1, $memberID);
    $stmt -> bindParam(2, $NOWID);

    $stmt -> execute();
  }

  //
  // member_to_NOW_edit
  //
  public function member_to_NOW_edit()
  {

  }

  //
  // member_to_NOW_remove
  //
  public function member_to_NOW_remove($phone, $NOWID)
  {

  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // "quick reports"
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // get_prayer_requests
  //
  public function get_prayer_requests()
  {
    //
    // Returns a list of all people and their payer requests
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, PrayerRequest FROM members");

    $stmt -> execute();

    return $stmt -> fetchAll();
  }

  //
  // get_contact_emails
  //
  public function get_contact_emails()
  {
    //
    // Gets all the members who are opted in for email blasts
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, EmailAddress FROM members WHERE OptEmail = ?");

    $stmt -> bindParam(1, true);

    return $stmt -> fetchAll();
  }

  //
  // get_contact_texts
  //
  public function get_contact_texts()
  {
    //
    // Gets all the members whos opted in for the texts blasts
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, PhoneNumber FROM members WHERE OptTexts =?");

    $stmt -> bindParam(1, true);

    return $stmt -> fetchAll();
  }

  //
  // get_members_in_lifeGroups
  //
  public function get_members_in_lifeGroups()
  {
    //
    // Returns a list of all the members in a life group
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, LifeGroup FROM members WHERE LifeGroupID != NULL");

    return $stmt -> fetchALl();
  }

  //
  // get_members_not_in_lifeGroups
  //
  public function get_members_not_in_lifeGroups()
  {
    //
    // Returns a list of all the member not in a life group
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, EmailAddress, PhoneNumber FROM members WHERE LifeGroupID = NULL");

    return $stmt -> fetchAll();
  }

  //
  // get_member_addresses
  //
  public function get_member_addresses()
  {
    //
    // Gets a list of all the member's addresses that do have their addresses in
    // the DB
    //
    $stmt = $this -> connection -> prepare("SELECT FirstName, LastName, HomeAddress FROM members WHERE HomeAddress != NULL");

    return $stmt -> fetchAll();
  }
}
?>
