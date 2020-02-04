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
include 'get_salt.php';
include 'console_log.php';

class db_query
{
  //
  // Properties
  //
  private $connection;
  private $query;
  private $salt;

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
      $this -> salt = get_salt();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in db_query constructor: ' .  $e->getMessage());
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
    // Check if the user exists and entered correct login data, then returns
    // true if found, or false if not found
    try
    {
      $stmt = $this -> connection -> prepare("SELECT email, password FROM admins WHERE email = ?");
      $stmt -> bindParam(1, $email);
      $stmt -> execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result != null)
      {
        if(count($result) != 0) // not empty
        {
          return hash_equals($result['password'], crypt($password, $this -> salt));
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
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in admin_check: ' .  $e->getMessage());
    }
  }

  //
  // admin_create
  //
  public function admin_create(string $fname, string $lname, string $email, string $password)
  {
    // Takes the first name, last name, email, and password and stores them in the
    // database.
    try
    {
      $stmt = $this -> connection -> prepare("INSERT INTO admins (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
      $stmt -> bindParam(1, $fname);
      $stmt -> bindParam(2, $lname);
      $stmt -> bindParam(3, $email);
      $stmt -> bindParam(4, crypt($password, $this -> salt));
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in admin_create: ' .  $e->getMessage());
    }
  }

  //
  // admin_edit
  //
  public function admin_edit(string $field, string $equals, $fname=null, $lname=null, $email=null, $password=null)
  {
    // Takes the number of the member to find in the DB.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
    try
    {
      $query = "UPDATE admins SET first_name = ";
      if($fname != null)
      {
        $query .= "'" . $fname . "',";
      }
      else
      {
        $query .= "first_name, ";
      }
      $query .= "last_name = ";
      if($lname != null)
      {
        $query .= "'" . $lname . "', ";
      }
      else
      {
        $query .= "last_name, ";
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
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in admin_create: ' .  $e->getMessage());
    }
  }

  //
  // admin_remove
  //
  public function admin_remove(string $field, string $equals)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    try
    {
      $stmt = $this -> connection -> prepare("DELETE FROM admins WHERE " . $field . " = '" . $equals . "'");
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in admin_create: ' .  $e->getMessage());
    }
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
    $stmt = $this -> connection -> prepare("SELECT group_name FROM groups WHERE id = ?");
    $stmt -> bindParam(1, $groupID);
    $stmt -> execute();
    return ($stmt -> fetch(PDO::FETCH_ASSOC))['group_name'];
  }

  //
  // get_group_id
  //
  // returns false if no group id exists for given name
  public function get_group_id($groupName)
  {
    $stmt = $this -> connection -> prepare("SELECT id FROM groups WHERE group_name = ?");
    $stmt -> bindParam(1, $groupName);
    $stmt -> execute();
    $response = $stmt -> fetch(PDO::FETCH_NUM);
    if ($response != null) return $response[0];
    else return false;
  }

  //
  // group_create
  //
  public function group_create(string $name)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO groups (group_name) VALUES (?)");
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
    $stmt = $this -> connection -> prepare("DELETE FROM groups WHERE " + $field + " = " + $equals);
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
    $stmt = $this -> connection -> prepare("SELECT id, life_group_name, life_group_day, life_group_time, life_group_location FROM life_groups WHERE " . $field . " = '" . $equals . "'");
    $stmt -> execute();
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    if ($result != null) return $result;
    else return false;
  }

  //
  // life_group_create
  //
  // NOTE: day can only be 9 chars at max and time in HH:MM:SS 24hr format
  public function life_group_create(string $name, string $day, string $time, string $location)
  {
    // Takes the name of the life group, the weekly day of the meeting, the time
    // at the meeting, and a description of the meeting.
    $stmt = $this -> connection -> prepare("INSERT INTO life_groups (life_group_name, life_group_day, life_group_time, life_group_location, life_group_active) VALUES (?, ?, ?, ?, ?)");
    $stmt -> bindParam(1, $name);
    $stmt -> bindParam(2, $day);
    $stmt -> bindParam(3, $time);
    $stmt -> bindParam(4, $location);
    $stmt -> bindParam(5, 1);
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
    $query = "UPDATE life_groups SET life_group_name = ";
    if($name != null)
    {
      $query .= "'" . $name . "',";
    }
    else
    {
      $query .= "life_group_name, ";
    }
    $query .= "life_group_day = ";
    if($day != null)
    {
      $query .= "'" . $day . "', ";
    }
    else
    {
      $query .= "life_group_day, ";
    }
    $query .= "life_group_time = ";
    if($time != null)
    {
      $query .= "'" . $time . "', ";
    }
    else
    {
      $query .= "life_group_time, ";
    }
    $query .= "life_group_location = ";
    if($location != null)
    {
      $query .= "'" . $location . "' ";
    }
    else
    {
      $query .= "life_group_location ";
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
    // This function return some kind of datatype with all of the
    // member's data in it. or false if no such member exists for the number
    try
    {
      $stmt = $this -> connection -> prepare("SELECT id, first_name, last_name, email, phone_number, home_address, home_church, major, prayer_request, photo_path, opt_email, opt_text, group_id FROM members WHERE phone_number = ?");
      $stmt -> bindParam(1, $number);
      $stmt -> execute();
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
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_check: ' .  $e->getMessage());
    }
  }

  //
  // member_create
  //
  public function member_create(string $fname, string $lname, string $number, $email=null, $address=null, $major=null, $photoPath=null, $prayerR=null, $optE=0, $optT=0, $groupID=1)
  {
    // Creates a new member taking the first and last name with their number.
    try
    {
      $stmt = $this -> connection -> prepare("INSERT INTO members (first_name, last_name, email, home_address, major, phone_number, photo_path, prayer_request, opt_email, opt_text, group_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      /*if($email == null)
      {
        $email = null;
      }
      if($address == null)
      {
        $address = null;
      }
      if($major == null)
      {
        $major = null;
      }
      if($photoPath == null)
      {
        $photoPath = null;
      }
      if($prayerR == null)
      {
        $prayerR = null;
      }*/
      if($optE == null)
      {
        $optE = 0;
      }
      if($optT == null)
      {
        $optT = 0;
      }
      if($groupID == null)
      {
        $groupID = 8;
      }

      $stmt -> bindParam(1, $fname);
      $stmt -> bindParam(2, $lname);
      $stmt -> bindParam(3, $email);
      $stmt -> bindParam(4, $address);
      $stmt -> bindParam(5, $major);
      $stmt -> bindParam(6, $number);
      $stmt -> bindParam(7, $photoPath);
      $stmt -> bindParam(8, $prayerR);
      $stmt -> bindParam(9, $optE);
      $stmt -> bindParam(10, $optT);
      $stmt -> bindParam(11, $groupID);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_create: ' .  $e->getMessage());
    }
  }


  public function member_edit(string $number, $fname=null, $lname=null, $numberN=null, $email=null, $address=null, $major=null, $photoPath=null, $prayerR=null, $optE=null, $optT=null, $groupID=null)
  {
    // Takes the number of the member to find in the db.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
    // Start + FirstName
    try
    {
      $query = "UPDATE members SET first_name = ";
      if($fname != null)
      {
        $query .= "'" . $fname . "',";
      }
      else
      {
        $query .= "first_name, ";
      }
      // LastName
      $query .= "last_name = ";
      if($lname != null)
      {
        $query .= "'" . $lname . "', ";
      }
      else
      {
        $query .= "last_name, ";
      }
      // PhoneNumber
      $query .= "phone_number = ";
      if($numberN != null)
      {
        $query .= "'" . $numberN . "', ";
      }
      else
      {
        $query .= "phone_number, ";
      }
      // EmailAddress
      $query .= "email = ";
      if($email != null)
      {
        $query .= "'" . $email . "', ";
      }
      else
      {
        $query .= "email, ";
      }
      // HomeAddress
      $query .= "home_address = ";
      if($address != null)
      {
        $query .= "'" . $address . "', ";
      }
      else
      {
        $query .= "home_address, ";
      }
      // Major
      $query .= "major = ";
      if($major != null)
      {
        $query .= "'" . $major . "', ";
      }
      else
      {
        $query .= "major, ";
      }
      // PhotoPath
      $query .= "photo_path = ";
      if($photoPath != null)
      {
        $query .= "'" . $photoPath . "', ";
      }
      else
      {
        $query .= "photo_path, ";
      }
      // PrayerRequest
      $query .= "prayer_request = ";
      if($prayerR != null)
      {
        $query .= "'" . $prayerR . "', ";
      }
      else
      {
        $query .= "prayer_request, ";
      }
      // OptEmail
      $query .= "opt_email = ";
      if($optE != null)
      {
        $query .= "'" . $optE . "', ";
      }
      else
      {
        $query .= "opt_email, ";
      }
      // OptText
      $query .= "opt_text = ";
      if($optT != null)
      {
        $query .= "'" . $optT . "', ";
      }
      else
      {
        $query .= "opt_text, ";
      }
      // GroupID
      $query .= "group_id = ";
      if($groupID != null)
      {
        $query .= "'" . $groupID . "' ";
      }
      else
      {
        $query .= "group_id ";
      }

      $query .= "WHERE phone_number = '" . $number . "' ";
      //echo $query;
      $stmt = $this -> connection -> prepare($query);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_edit: ' .  $e->getMessage());
    }
  }

  //
  // member_remove
  //
  public function member_remove(string $number)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    try
    {
      $stmt = $this -> connection -> prepare("DELETE FROM members WHERE phone_number = ?");
      $stmt -> bindParam(1, $number);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_remove: ' .  $e->getMessage());
    }
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
    try
    {
      $stmt = $this -> connection -> prepare("SELECT id, now_date FROM nights_of_worship WHERE now_date = ?");
      $stmt -> bindParam(1, $date);
      $stmt -> execute();
      $response = $stmt -> fetch(PDO::FETCH_ASSOC);
      if($response != null) return $response;
      else return false;
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in NOW_check: ' .  $e->getMessage());
    }
  }
  //
  // NOW_create
  //
  public function NOW_create(string $date)
  {
    // Expects dates to be in the YYYY-MM-DD format
    try
    {
      $stmt = $this -> connection -> prepare("INSERT INTO nights_of_worship (now_date) VALUES (?)");
      $stmt -> bindParam(1, $date);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in NOW_create: ' .  $e->getMessage());
    }
  }

  //
  // NOW_edit
  //
  public function NOW_edit(string $dateOld, string $dateNew)
  {
    // Expects dates to be in the YYYY-MM-DD format
    try
    {
      $stmt = $this -> connection -> prepare("UPDATE nights_of_worship SET now_date = ? WHERE now_date = ?");
      $stmt -> bindParam(1, $dateNew);
      $stmt -> bindParam(2, $dateOld);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in NOW_edit: ' .  $e->getMessage());
    }
  }

  //
  // NOW_remove
  //
  public function NOW_remove(string $date)
  {
    try
    {
      $stmt = $this -> connection -> prepare("DELETE FROM nights_of_worship WHERE now_date = ?");
      $stmt -> bindParam(1, $date);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in NOW_remove: ' .  $e->getMessage());
    }
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
    try
    {
      $query = "SELECT id, member_id, life_group_id FROM member_life_group_junction WHERE ";
      // MemberID
      $query .= "member_id = ";
      if($memberID != null)
      {
        $query .= "'" . $memberID . "' AND ";
      }
      else
      {
        $query .= "member_id AND ";
      }
      // LifeGroupID
      $query .= "life_group_id = ";
      if($life_groupID != null)
      {
        $query .= "'" . $life_groupID . "'";
      }
      else
      {
        $query .= "life_group_id ";
      }
      $stmt = $this -> connection -> prepare($query);
      $stmt -> execute();
      $response = $stmt -> fetchAll(PDO::FETCH_ASSOC);
      if($response != null) return $response;
      else return false;
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_to_life_group_check: ' .  $e->getMessage());
    }
  }

  //
  // member_to_life_group_create
  //
  public function member_to_life_group_create($memberID, $life_groupID)
  {
    try
    {
      $stmt = $this -> connection -> prepare("INSERT INTO member_life_group_junction (member_id, life_group_id) VALUE (?, ?)");
      $stmt -> bindParam(1, $memberID);
      $stmt -> bindParam(2, $life_groupID);
      $stmt -> execute();
    }
    catch(Exception | PDOException $e)
    {
      console_log('Caught exception in member_to_life_group_create: ' .  $e->getMessage());
    }
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
    $stmt = $this -> connection -> prepare("DELETE FROM member_life_group_junction WHERE member_id = ? AND life_group_id = ?");
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
    $query .= "member_id = ";
    if($memberID != null)
    {
      $query .= "'" . $memberID . "', ";
    }
    else
    {
      $query .= "member_id, ";
    }
    // LifeGroupID
    $query .= "now_id = ";
    if($NOWID != null)
    {
      $query .= "'" . $NOWID . "' ";
    }
    else
    {
      $query .= "now_id ";
    }

    $stmt = $this -> connection -> prepare($query);
    $stmt -> execute();
    $response = $stmt -> fetch(PDO::FETCH_ASSOC);
    if($response != null) return $response;
    else return false;
  }

  //
  // member_to_NOW_create
  //
  public function member_to_NOW_create($memberID, $NOWID)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO member_nights_of_worship_junction (member_id, now_id) VALUES (?, ?)");

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
    // Returns a list of all people and their payer requests
    $stmt = $this -> connection -> prepare("SELECT first_name, last_name, prayer_request FROM members");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  //
  // get_contact_emails
  //
  public function get_contact_emails()
  {
    // Gets all the members who are opted in for email blasts
    $stmt = $this -> connection -> prepare("SELECT first_name, last_name, email FROM members WHERE opt_email = ?");
    $stmt -> bindParam(1, 1);
    return $stmt -> fetchAll();
  }

  //
  // get_contact_texts
  //
  public function get_contact_texts()
  {
    // Gets all the members whos opted in for the texts blasts
    $stmt = $this -> connection -> prepare("SELECT first_name, last_name, phone_number FROM members WHERE opt_text = ?");
    $stmt -> bindParam(1, 1);
    return $stmt -> fetchAll();
  }

  //
  // get_members_in_lifeGroups
  //
  public function get_members_in_lifeGroups()
  {
    // Returns a list of all the members in a life group
    $stmt = $this -> connection -> prepare("SELECT id, member_id, life_group_id FROM member_life_group_junction");
    return $stmt -> fetchAll();
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
