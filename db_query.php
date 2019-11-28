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
*   admin_edit(string $field, string $equals, array $changingFields, array $newValues)
*   admin_remove(string $field, string $equals)
*
*   group_create()
*   group_edit()
*   group_remove()
*
*   life_group_create()
*   life_group_edit()
*   life_group_remove()
*
*   member_check()
*   member_create()
*   member_edit()
*   member_remove()
*
*   member_to_life_group_create()
*   member_to_life_group_edit()
*   member_to_life_group_remove()
*
*   member_to_NOW_create()
*   member_to_NOW_edit()
*   member_to_NOW_remove()
*
*   NOW_create()
*   NOW_edit()
*   NOW_remove()
*
*/
include 'db_connect.php'

class db_query
{
  //
  // Properties
  //
  private $connection;
  private $query;

  //
  // This is for creating the db_queue
  //
  function __construct()
  {
    // Set queue variable to an empty string
    $this -> query = "";

    // Setup the connection with the database
    try
    {
      $this -> connection = db_connect();
      echo "Query constructed and connected."
    }
    catch
    {
      echo "Query didn't connect to the database."
    }
  }

  //
  // This is for destruction
  //
  function __destruct()
  {

  }

  //
  // Check if the user exists and entered correct login data, then returns bool
  //
  public function admin_check(string $email, string $password)
  {
    $stmt = $this -> connection -> perpare("SELECT * FROM admins WHERE email = ? AND password = ?");

    $stmt -> bindParam(1, $email);
    $stmt -> bindParam(2, $password);

    $sth->execute();

    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if(($result != NULL || "") || ($result == false))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  //
  // Takes the first name, last name, email, and password and stores them in the
  // database.
  //
  public function admin_create(string $fname, string $lname, string $email, string $password)
  {
    $stmt = $this -> connection -> prepare("INSERT INTO admins (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");

    $stmt -> bindParam(1, $fname);
    $stmt -> bindParam(2, $lname);
    $stmt -> bindParam(3, $email);
    $stmt -> bindParam(4, $password);

    $stmt -> execute();
  }

  //
  // Takes the field of concern and what it should be looking for in the field.
  // Then takes 2 arrays, one of the fields that will be changing and the second
  // of the coorisponding values that it will be changing to.
  //
  function admin_edit(string $field, string $equals, array $changingFields, array $newValues)
  {
    if(count($changingFields) == count($newValues))
    {
      $query = "UPDATE admins SET";

      foreach($changingFields as $index => $field)
      {
        $query .= " " + $field + " = ?,";
      }
    }
    else
    {
      trigger_error("Arrays of unequal length.");
    }
  }

  //
  // Take the field of concern and what it should equal to be removed from the
  // database.
  //
  function admin_remove(string $field, string $equals)
  {
    $stmt = $this -> connection -> prepare("DELETE FROM admins WHERE " + $field + " = " + $equals);

    $stmt -> execute();
  }

  //
  function group_create()
  {

  }

  //
  function group_edit()
  {

  }

  //
  function group_remove()
  {

  }

  // Takes the name of the life group, the weekly day of the meeting, the time
  // at the meeting, and a description of the meeting.
  //
  // NOTE: day can only be 9 chars at max
  function life_group_create(string $name, string $day, string $time, string $location)
  {

  }

  // Takes the field of concern and what it should be looking for in the field.
  // Then takes 2 arrays, one of the fields that will be changing and the second
  // of the coorisponding values that it will be changing to.
  function life_group_edit(string $field, string $equals, array $changingFields, array $newValues)
  {

  }

  // Take the field of concern and what it should equal to be removed from the
  // database.
  function life_group_remove(string $field, string $equals)
  {

  }

  //
  function member_check(string $number)
  {

  }

  // Creates a new member taking the first and last name with their number.
  // NOTE: to add other data to the create member, call member_edit
  function member_create(string $fname, string $lname, string $number)
  {

  }

  // Takes the field of concern and what it should be looking for in the field.
  // Then takes 2 arrays, one of the fields that will be changing and the second
  // of the coorisponding values that it will be changing to.
  function member_edit(string $field, string $equals, array $changingFields, array $newValues)
  {

  }

  // Take the field of concern and what it should equal to be removed from the
  // database.
  function member_remove(string $field, string $equals)
  {

  }

}
 ?>
