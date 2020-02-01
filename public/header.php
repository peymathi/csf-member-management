<?php
include 'checkinUserClass.php';
include 'phpUtil/sessionVerification.php';
session_start();
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/custom_style.css">
	<title>Impact:
	<?php
	
	//life_group_dashboard.php, modify_life_groups.php, reports_dashboard.php, report_prayers.php
	//report_contacts.php, report_life_groups.php, report_addresses.php
	if(basename($_SERVER['PHP_SELF'])=="index.php") print 'Homepage';
		else if(basename($_SERVER['PHP_SELF'])=="dashboard.php") print 'Dashboard';
		else if(basename($_SERVER['PHP_SELF'])=="preCheckin.php") print 'Pre Check In';
		else if(basename($_SERVER['PHP_SELF'])=="checkin.php") print 'Check In';
		else if(basename($_SERVER['PHP_SELF'])=="login.php") print 'Log In';
		else if(basename($_SERVER['PHP_SELF'])=="register.php") print 'Register';
		else if(basename($_SERVER['PHP_SELF'])=="edit_member.php") print 'Edit Member';
		else if(basename($_SERVER['PHP_SELF'])=="member_management.php") print 'Member Management';
		else if(basename($_SERVER['PHP_SELF'])=="change_password.php") print 'Change Password';
		else if(basename($_SERVER['PHP_SELF'])=="forgot_password.php") print 'Password Reset';
		
		
		else if(basename($_SERVER['PHP_SELF'])=="life_group_dashboard.php") print 'Life Group Dashboard';
		else if(basename($_SERVER['PHP_SELF'])=="modify_life_groups.php") print 'Modify Life Groups';
		else if(basename($_SERVER['PHP_SELF'])=="reports_dashboard.php") print 'Reports Dashboard';
		else if(basename($_SERVER['PHP_SELF'])=="report_prayers.php") print 'Prayers Report';
		else if(basename($_SERVER['PHP_SELF'])=="report_contacts.php") print 'Contacts Report';
		else if(basename($_SERVER['PHP_SELF'])=="report_life_groups.php") print 'Life Groups Report';
		else if(basename($_SERVER['PHP_SELF'])=="report_addresses.php") print 'Addresses Report';
	?>
	</title>

</head>
