<?php 
include 'header.php';

//TODO: need to change session variables to not allow user to access dashboard

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
	exit;
}
require_once "db_connect.php";
$phone = "";

$phone_error = "";

$UserCheckin = new UserCheckin();


if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST["phone"]))){
		$phone_error = "Must enter phone Number in format: 3175551234.";
	} else {
		$phone = trim($_POST["phone"]);
	}
	if(empty($phone_error)){
		$checkinStmt = $con->prepare('SELECT * FROM members WHERE PhoneNumber = :phone');
		$checkinStmt->execute(array('phone'=>$phone));
		if($checkinStmt->rowCount() != 1){
			$phone_error = "Login Unsuccessful. Please Try Another Phone Number.";
		}else{
			$row = $checkinStmt->fetch(PDO::FETCH_OBJ);
			$UserCheckin->setMemberID($row->MemberID);
			$UserCheckin->setFirstName($row->FirstName);
			$UserCheckin->setLastName($row->LastName);
			$UserCheckin->setEmailAddress($row->EmailAddress);
			$UserCheckin->setHomeAddress($row->HomeAddress);
			$UserCheckin->setPhoneNumber($row->PhoneNumber);
			$UserCheckin->setPhotoPath($row->PhotoPath);
			$UserCheckin->setPrayerRequest($row->PrayerRequest);
			$UserCheckin->setOptEmail($row->OptEmail);
			$UserCheckin->setOptText($row->OptText);
			$UserCheckin->setGroupID($row->GroupID);
			$_SESSION["UserCheckin"] = $UserCheckin;
			Header("Location:edit_member.php");
		}
	}
}

?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Check In</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="tel" pattern="[0-9]{10}" required>Phone Number:</label>
				<input type="tel" class="form-control" id="phone" placeholder="3175551234" name="phone" required>
				<span class="help-block"><?php echo $phone_error; ?></span>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <button type="submit" class="btn btn-primary">Check In</button>
			</form>
		</div>
	</div>
	<script src="checkin.js"></script>
</div>
</body>
</html>
