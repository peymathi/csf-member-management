<?php
/**
 * This file defines PDO database package. This file is included in any files that needs database connection
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
 * http://php.net/manual/en/pdostatement.fetch.php
  */
/*** mysql hostname ***/
$hostname = 'localhost';
/*** mysql username ***/
$username = 'root';
/*** mysql password ***/
$password = '';
try {
    $con = new PDO("mysql:host=$hostname;dbname=csfi_db", $username, $password);

    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }

// Returns the connection object to the database.
function db_connect($hostname = 'localhost', $username = 'root', $password = '')
{
  try
  {
    return new PDO("mysql:host=$hostname;dbname=csfi_db", $username, $password);
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
  }
}
?>
