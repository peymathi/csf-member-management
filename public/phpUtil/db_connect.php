<?php

// Returns the connection object to the database.
function db_connect($hostname = 'localhost', $username = 'root', $password = '')
{
  /*** mysql hostname ***/
  $hostname = 'localhost';
  /*** mysql username ***/
  $username = 'member_data_app';
  /*** mysql password ***/
  $filepath = "../../dbcon.txt";
  $file = fopen($filepath);
  $password = fread($file, filesize($filepath));
  $password = trim($password);
  try
  {
    return new PDO("mysql:host=$hostname;dbname=MEMBER_DATA_MANAGEMENT", $username, $password);
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}
?>
