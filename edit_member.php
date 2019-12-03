<?php
include 'header.php';
session_verify();


require_once "phpUtil/db_connect.php";

$UserCheckin = $_SESSION["UserCheckin"];
$MemberID = $UserCheckin->getMemberID();
$FirstName = $UserCheckin->getFirstName();
$LastName = $UserCheckin->getLastName();
$Email = $UserCheckin->getEmailAddress();
$HomeAddress = $UserCheckin->getHomeAddress();
$PhoneNumber = $UserCheckin->getPhoneNumber();
$PhotoPath = $UserCheckin->getPhotoPath();
$PrayerRequest = $UserCheckin->getPrayerRequest();
$OptEmail = $UserCheckin->getOptEmail();
$OptText = $UserCheckin->getOptText();
$GroupID = $UserCheckin->getGroupID();
$LifeGroupID = $UserCheckin->getLifeGroupID();

//TODO Not default major and Graduation Date to Null
$major = "";

$first_name_error = "";
$last_name_error = "";
$email_error = "";
$phone_number_error = "";
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
	if(empty(trim($_POST["major"]))){
		$major_error = "Must enter major.";
	} else {
		$major = trim($_POST["major"]);
	}
	if(empty(trim($_POST["group_id"]))){
		//$group_error = "Must enter group.";
		$GroupID = null;
	} else {
		$GroupID = trim($_POST["group_id"]);
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
	!empty($major_error) || !empty($home_address_error) || !empty($life_group_error)
	){
		$any_error = "errors";
	}

	if(empty($any_error)){
		//UPDATE `members` SET `FirstName`=[value-2],`LastName`=[value-3],`EmailAddress`=[value-4],`HomeAddress`=[value-5],`PhoneNumber`=[value-6],
		//`PhotoPath`=[value-7],`PrayerRequest`=[value-8],`OptEmail`=[value-9],`OptText`=[value-10],`GroupID`=[value-11] WHERE `MemberID`=[value-1];
		$updateStmt = $con->prepare("UPDATE members set FirstName = :FirstName, LastName = :LastName, EmailAddress = :EmailAddress, HomeAddress = :HomeAddress,
		PhoneNumber = :PhoneNumber, Major = :Major, PhotoPath = :PhotoPath, PrayerRequest = :PrayerRequest, OptEmail = :OptEmail, OptText = :OptText, GroupID = :GroupID WHERE MemberID = :MemberID");
		$updateStmt->execute(array('FirstName' => $FirstName, 'LastName' => $LastName, 'EmailAddress' => $Email, 'HomeAddress' => $HomeAddress,'PhoneNumber' => $PhoneNumber,
		'Major' => $major, 'PhotoPath' => $PhotoPath, 'PrayerRequest' => $PrayerRequest, 'OptEmail' => $OptEmail, 'OptText' => $OptText, 'GroupID' => $GroupID, 'MemberID' => $MemberID));
		$_SESSION['UserCheckin'] = Null;
		Header("location: member_management.php");
	}
}

?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
<?php 
include 'headerMembers.php';
include 'form.php'; 
?>
<script src="edit_member.js"></script>
</body>
</html>
