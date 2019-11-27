<?php
/*
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
 ?>
