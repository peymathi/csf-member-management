<?php
include 'header.php';
//TODO: need to add session variables to not allow user to access dashboard

//include "phpUtil/sessionVerification.php";
//session_verify();


require_once "db_connect.php";
$MemberID = "";
$FirstName = "";
$LastName = "";
$Email = "";
$HomeAddress = "";
$PhoneNumber = "";
$PhotoPath = "";
$PrayerRequest = "";
$OptEmail = 1;
$OptText = 1;
$GroupID = 1;

$Major = "";
$GraduationDate = "";

$first_name_error = "";
$last_name_error = "";
$email_error = "";
$phone_number_error = "";
$graduation_date_error = "";
$major_error = "";
$life_group_error = "";
$home_address_error = "";
$any_error = "";

$opt_email_checked="";
$opt_phone_checked="";
if($OptText == "1"){
	$opt_phone_checked="checked";
}
if($OptEmail == "1"){
	$opt_email_checked="checked";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){//will update user info here
	if(empty(trim($_POST["email"]))){
		$email_error = "Must enter email.";
	} else {
		$Email = trim($_POST["email"]);
	}
	if(empty(trim($_POST["first_name"]))){
		$first_name_error = "Must enter first name.";
	} else {
		$FirstName = trim($_POST["first_name"]);
	}
	if(empty(trim($_POST["last_name"]))){
		$last_name_error = "Must enter last name.";
	} else {
		$LastName = trim($_POST["last_name"]);
	}
	if(empty(trim($_POST["phone_number"]))){
		$phone_number_error = "Must enter phone number.";
	} else {
		$PhoneNumber = trim($_POST["phone_number"]);
	}
	if(empty(trim($_POST["graduation_date"]))){
		$graduation_date_error = "Must enter graduation date.";
	} else {
		$graduation_date = trim($_POST["graduation_date"]);
	}
	if(empty(trim($_POST["major"]))){
		$major_error = "Must enter major.";
	} else {
		$major = trim($_POST["major"]);
	}
	if(empty(trim($_POST["life_group_id"]))){
		$GroupID = null;
	} else {
		$GroupID = trim($_POST["life_group_id"]);
	}
	if(empty(trim($_POST["home_address"]))){
		$home_address_error = "Must enter home address.";
	} else {
		$HomeAddress = trim($_POST["home_address"]);
	}
	if(isset($_POST["opt_text"])){ //if opted in set 1 else 0
		$OptText = 1;
	} else {
		$OptText = 0;
	}
	if(isset($_POST["opt_email"])){ //if opted in set 1 else 0
		$OptEmail = 1;
	} else {
		$OptEmail = 0;
	}
	if(empty(trim($_POST["prayer_request"]))){
		$PrayerRequest = "";
	} else {
		$PrayerRequest = trim($_POST["prayer_request"]);
	}
	//if any of these errors are not empty, then don't add anything to db
	if(
	!empty($email_error) || !empty($first_name_error) || !empty($last_name_error) || !empty($phone_number_error) ||
	!empty($major_error) ||	!empty($graduation_date_error) || !empty($home_address_error) || !empty($life_group_error)
	){
		$any_error = "errors";
		//$any_error = $MemberID."   : ".$FirstName." ".$LastName." ".$EmailAddress." ".$HomeAddress." ".$PhoneNumber." ".$PhotoPath." ".$PrayerRequest." ".$OptEmail." ".$OptEmail." ".$GroupID;
	}
	
	if(empty($any_error)){
		//UPDATE `members` SET `FirstName`=[value-2],`LastName`=[value-3],`EmailAddress`=[value-4],`HomeAddress`=[value-5],`PhoneNumber`=[value-6],
		//`PhotoPath`=[value-7],`PrayerRequest`=[value-8],`OptEmail`=[value-9],`OptText`=[value-10],`GroupID`=[value-11] WHERE `MemberID`=[value-1];
		$updateStmt = $con->prepare('INSERT INTO members (`MemberID`, `FirstName`, `LastName`, `EmailAddress`, `HomeAddress`, `PhoneNumber`, `PhotoPath`, `PrayerRequest`, `OptEmail`, `OptText`, `GroupID`) VALUES
		(NULL, :FirstName, :LastName, :EmailAddress, :HomeAddress, :PhoneNumber, :PhotoPath, :PrayerRequest, :OptEmail, :OptText, :GroupID)');
		$updateStmt->execute(array('FirstName' => $FirstName, 'LastName' => $LastName, 'EmailAddress' => $Email, 'HomeAddress' => $HomeAddress,
		'PhoneNumber' => $PhoneNumber, 'PhotoPath' => $PhotoPath, 'PrayerRequest' => $PrayerRequest, 'OptEmail' => $OptEmail, 'OptText' => $OptEmail, 'GroupID' => $GroupID));
		Header("location: checkin.php");
	}
}


?>




<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
<?php include 'form.php'; ?>
<script src="register.js"></script>
</body>
</html>
