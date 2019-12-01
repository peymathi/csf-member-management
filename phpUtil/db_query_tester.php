<?php
/*
* This file is primarily for testing perposes.
*/
include "db_query.php";

$query = new db_query();
echo "the query and a connection to db was successfully created!\n";

$query -> admin_create('Corey','Stockton','coreystockton4c@gmail.com','incorrect');

$query -> admin_check('coreystockton4c@gmail.com','incorrect');

$query -> admin_edit('')
?>
