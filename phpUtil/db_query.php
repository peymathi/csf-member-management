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
*   TODO: admin_edit(string $field, string $equals, string $fname='firstname',
        string $lname='lastname', string $email='email',
        string $password='password')
*   admin_remove(string $field, string $equals)
*
*   TODO: group_check(string $name)
*   group_create(string $name)
*   TODO: group_edit()
*   group_remove(string $field, string $equals)
*
*   life_group_create(string $name, string $day, string $time, string $location)
*   TODO: life_group_edit()
*   life_group_remove(string $field, string $equals)
*
*   member_check(string $number)
*   member_create(string $fname, string $lname, string $number,
        string $email="NULL", string $address="NULL", string $major="NULL",
        string $photoPath="NULL", string $prayerR="NULL", string $optE="false",
        string $optT="false")
*   TODO: member_edit(string $number, string $fname='FirstName',
        string $lname='LastName', string $email='EmailAddress',
        string $adrs='HomeAddress', string $number='PhoneNumber',
        string $photoPath='PhotoPath', string $prayerR='PrayerRequest',
        string $optE='OptEmail', string $optT='OptText')
*   member_remove(string $field, string $equals)
*
*   TODO: member_to_life_group_create()
*   TODO: member_to_life_group_edit()
*   TODO: member_to_life_group_remove()
*
*   TODO: member_to_NOW_create()
*   TODO: member_to_NOW_edit()
*   TODO: member_to_NOW_remove()
*
*   NOW_create(string $date)
*   TODO: NOW_edit()
*   TODO: NOW_remove()
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

    if(count($result) != 0)
    {
      return $result;
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
    $this -> connection -> commit();
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
  // group_create
  //
  public function group_create(string $name)
  {
    $stmt = $this -> connection -> perpare("INSERT INTO groups (GroupName) VALUES (?)");

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
  // life_group_create
  //
  // NOTE: day can only be 9 chars at max
  public function life_group_create(string $name, string $day, string $time, string $location)
  {
    // Takes the name of the life group, the weekly day of the meeting, the time
    // at the meeting, and a description of the meeting.
    $stmt = $this -> connection -> perpare("INSERT INTO lifeGroup (LifeGroupName, LifeGroupDate, LifeGroupTime, LifeGroupLocation) VALUES (?, ?, ?, ?)");

    $stmt -> bindParam(1, $name);
    $stmt -> bindParam(2, $date);
    $stmt -> bindParam(3, $time);
    $stmt -> bindParam(4, $location);

    $stmt -> execute();
  }

  //
  // life_group_edit
  //
  public function life_group_edit(string $field, string $equals, array $changingFields, array $newValues)
  {
    // Takes the field of concern and what it should be looking for in the field.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.
  }

  //
  // life_group_remove
  //
  public function life_group_remove(string $field, string $equals)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    $stmt = $this -> connection -> prepare("DELETE FROM lifeGroup WHERE " + $field + " = " + $equals);

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
    $stmt = $this -> connection -> prepare("SELECT * FROM member WHERE PhoneNumber = ?");

    $stmt -> bindParam(1, $number);

    $stmt -> execute();

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    if(count($result) != 0) // not empty
    {
      return $result;
    }
    else
    {
      return false;
    }
  }

  //
  // member_create
  //
  public function member_create(string $fname, string $lname, string $number, string $email="NULL", string $address="NULL", string $major="NULL", string $photoPath="NULL", string $prayerR="NULL", string $optE="0", string $optT="0")
  {
    // Creates a new member taking the first and last name with their number.
    $stmt = $this -> connection -> prepare("INSERT INTO members (FirstName,LastName,EmailAddress,HomeAddress,Major,PhoneNumber,PhotoPath,PrayerRequest,OptEmail,OptText) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

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

    $stmt -> execute();
  }


  public function member_edit(string $field, string $equals, string $fname='FirstName', string $lname='LastName', string $email='EmailAddress', string $adrs='HomeAddress', string $number='PhoneNumber', string $photoPath='PhotoPath', string $prayerR='PrayerRequest', string $optE='OptEmail', string $optT='OptText')
  {
    // Takes the field of concern and what it should be looking for in the field.
    // Then takes 2 arrays, one of the fields that will be changing and the second
    // of the coorisponding values that it will be changing to.

  }

  //
  // member_remove
  //
  public function member_remove(string $field, string $equals)
  {
    // Take the field of concern and what it should equal to be removed from the
    // database.
    $stmt = $this -> connection -> prepare("DELETE FROM members WHERE " + $field + " = " + $equals);

    $stmt -> execute();
  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // NOW
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // NOW_create
  //
  public function NOW_create(string $date)
  {
    // Expects dates to be in the YYYY-MM-DD format
    $stmt = $this -> connection -> perpare("INSERT INTO nights_of_worship (NightDate) VALUES (?)");

    $stmt -> bindPara(1, $date);

    $stmt -> execute();
  }

  //
  // NOW_edit
  //
  public function NOW_edit()
  {

  }

  //
  // NOW_remove
  //
  public function NOW_remove()
  {

  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // member_to_life_group
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // member_to_life_group_create
  //
  public function member_to_life_group_create()
  {

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
  public function member_to_life_group_remove()
  {

  }

  //////////////////////////////////////////////////////////////////////////////
  //
  // member_to_NOW
  //
  //////////////////////////////////////////////////////////////////////////////

  //
  // member_to_NOW_create
  //
  public function member_to_NOW_create()
  {

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
  public function member_to_NOW_remove()
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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, PrayerRequest FROM members");

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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, EmailAddress FROM members WHERE OptEmail = ?");

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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, PhoneNumber FROM members WHERE OptTexts =?");

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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, LifeGroup FROM members WHERE LifeGroupID != NULL");

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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, EmailAddress, PhoneNumber FROM members WHERE LifeGroupID = NULL");

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
    $stmt = $this -> connection -> perpare("SELECT FirstName, LastName, HomeAddress FROM members WHERE HomeAddress != NULL");

    return $stmt -> fetchAll();
  }
}
?>
