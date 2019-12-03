<?php
/*
* This file is primarily for testing perposes.
*/
include "db_query.php";

$query = new db_query();
echo "the query and a connection to db was successfully created!\n";

$query -> admin_create('Peyton','Mathis','tuckerdooley@gmail.com',password_hash('adminadmin',PASSWORD_DEFAULT));

//echo count($query -> admin_check('coreystockton4c@gmail.com','incorrect'));

$query -> admin_edit('')
?>
