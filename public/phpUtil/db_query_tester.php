<?php
/*
* This file is primarily for testing perposes.
*/
include "db_query.php";

$query = new db_query();
echo "the query and a connection to db was successfully created!\n";

$query -> admin_create('Peyton','Mathis','tuckerdooley@gmail.com',password_hash('adminadmin',PASSWORD_DEFAULT));

//echo count($query -> admin_check('coreystockton4c@gmail.com','incorrect'));

//$query -> admin_edit('lastname', 'Stockton', 'Taylor', null, null, null);

//$query -> admin_remove('lastname', 'Stockton');

//$query -> member_create('Corey', 'Stockton','3177091130','coreystockton4c@gmail.com',null,'ME&CS',null,'Grades');

//echo implode(" ",($query -> member_check('3177091130')));

//$query -> member_edit('3177091130',null,null,null,null,'31 N Holmes',null,null,null,'1','1');

//$query -> member_remove('3177091130');

//$query -> NOW_create('2019-12-02');

//echo implode(" ", $query -> NOW_check('2019-12-02'));

//$query -> NOW_edit('2019-12-02','2019-12-09');

//$query -> NOW_remove('2019-12-09');

//$query -> life_group_create('Others','Friday','7:00AM','Taylor Hall 104');

//echo implode(" ", $query -> life_group_check('LifeGroupDay','Friday'));

//$query -> life_group_edit('LifeGroupName','Others','MisFits',null,null,null);

//$query -> life_group_remove('LifeGroupName','Lame Group');
?>
