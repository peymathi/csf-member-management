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
	if(basename($_SERVER['PHP_SELF'])=="index.php") print 'Homepage';
		else if(basename($_SERVER['PHP_SELF'])=="dashboard.php") print 'Dashboard';
		else if(basename($_SERVER['PHP_SELF'])=="checkin.php") print 'Check In';
		else if(basename($_SERVER['PHP_SELF'])=="login.php") print 'Log In';
		else if(basename($_SERVER['PHP_SELF'])=="register.php") print 'Register';
		else if(basename($_SERVER['PHP_SELF'])=="edit_member.php") print 'Edit Member';
		else if(basename($_SERVER['PHP_SELF'])=="change_password.php") print 'Change Password';
		else if(basename($_SERVER['PHP_SELF'])=="forgot_password.php") print 'Password Reset';
	?>
	</title>

</head>
