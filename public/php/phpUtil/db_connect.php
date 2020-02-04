<?php
function db_connect()
{
  /*** mysql hostname ***/
  $hostname = 'localhost';
  /*** mysql username ***/
  $username = 'member_data_app';
  /*** mysql password ***/
  $filepath = $_SERVER['DOCUMENT_ROOT'] . "/../dbcon.txt";
  $file = fopen($filepath, 'r');
  $password = fread($file, filesize($filepath));
  $password = trim($password);
  try
  {
    return new PDO("mysql:host=$hostname;dbname=MEMBER_DATA_MANAGEMENT", $username, $password);
  }
  catch(PDOException $e)
  {
    echo $e -> getMessage();
  }
}
?>
