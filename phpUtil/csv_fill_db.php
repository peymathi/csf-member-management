<?php

require_once 'db_query.php';

$query = new db_query();

$filename = 'data.csv';

// Open the file for reading
if (($h = fopen("{$filename}", "r")) !== FALSE)
{
  // Each line in the file is converted into an individual array that we call $data
  // The items of the array are comma separated
  $count = 0;
  while (($data = fgetcsv($h, 1000, ",")) !== FALSE)
  {
    if($count != 0)
    {
      $fname = $data[0];
      if($data[1] == "?")
      {
        $lname = "";
      }
      else
      {
        $lname = $data[1];
      }
      $email = $data[2];
      $numbr = str_replace(array('(',')','-'),'',$data[3]);
      $updat = $data[4]; // not using
      $lifeG = $data[5]; // can't use
      $query -> member_create($fname,$lname,$numbr,$email);
    }
    $count++;
  }

  // Close the file
  fclose($h);
}
echo "Success!";
// Display the code in a readable format
/*echo "<pre>";
var_dump($the_big_array);
echo "</pre>";*/
?>
