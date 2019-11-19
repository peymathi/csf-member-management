<?php 
include 'header.php';
//TODO: need to add session variables to not allow user to access dashboard

require_once "db_connect.php";
$UserCheckin = $_SESSION["UserCheckin"];
$MemberID = $UserCheckin->getMemberID();
$FirstName = $UserCheckin->getFirstName();
$LastName = $UserCheckin->getLastName();
$EmailAddress = $UserCheckin->getEmailAddress();
$HomeAddress = $UserCheckin->getHomeAddress();
$PhoneNumber = $UserCheckin->getPhoneNumber();
$PhotoPath = $UserCheckin->getPhotoPath();
$PrayerRequest = $UserCheckin->getPrayerRequest();
$OptEmail = $UserCheckin->getOptEmail();
//TODO: Fix OptText to read from $UserCheckin->getOptText();
//$OptText = $UserCheckin->getOptText();
$OptText = 1;
$GroupID = $UserCheckin->getGroupID();

/* TODO Not default major and Graduation Date to Null */
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
		$email = trim($_POST["email"]);
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
		//$life_group_error = "Must enter life group.";
		$GroupID = null;
	} else {
		$GroupID = trim($_POST["life_group_id"]);
	}
	if(empty(trim($_POST["home_address"]))){
		$home_address_error = "Must enter home address.";
	} else {
		$HomeAddress = trim($_POST["home_address"]);
	}
	if(isset($_POST["opt_text"])){ //if opted on set 1 else 0
		$OptText = 1;
	} else {
		$OptText = 0;
	}
	if(isset($_POST["opt_email"])){ //if opted on set 1 else 0
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
		$updateStmt = $con->prepare("UPDATE members set FirstName = :FirstName, LastName = :LastName, EmailAddress = :EmailAddress, HomeAddress = :HomeAddress,
		PhoneNumber = :PhoneNumber, PhotoPath = :PhotoPath, PrayerRequest = :PrayerRequest, OptEmail = :OptEmail, OptText = :OptText, GroupID = :GroupID WHERE MemberID = :MemberID");
		$updateStmt->execute(array('FirstName' => $FirstName, 'LastName' => $LastName, 'EmailAddress' => $EmailAddress, 'HomeAddress' => $HomeAddress,'PhoneNumber' => $PhoneNumber,
		'PhotoPath' => $PhotoPath, 'PrayerRequest' => $PrayerRequest, 'OptEmail' => $OptEmail, 'OptText' => $OptEmail, 'GroupID' => $GroupID, 'MemberID' => $MemberID));
		$_SESSION['UserCheckin'] = Null;
		Header("location: checkin.php");
	}
}
?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" value="<?php echo $EmailAddress; ?>" placeholder="Enter email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $email_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="first_name">First Name:</label>
				<input type="text" class="form-control" id="first_name" value="<?php echo $FirstName; ?>" placeholder="Enter first name" name="first_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $first_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="last_name">Last Name:</label>
				<input type="text" class="form-control" id="last_name" value="<?php echo $LastName; ?>" placeholder="Enter last name" name="last_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $last_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="phone_number">Phone Number:</label>
				<input type="text" class="form-control" id="phone_number" value="<?php echo $PhoneNumber; ?>" placeholder="Enter phone number" name="phone_number" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $phone_number_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="major">Major:</label>
				<input type="text" class="form-control" id="major" value="<?php echo $Major; ?>" placeholder="Enter major" name="major" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $major_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="graduation_date">Graduation Date:</label>
				<input type="text" class="form-control" id="graduation_date" value="<?php echo $GraduationDate; ?>" placeholder="Enter graduation date" name="graduation_date" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $graduation_date_error; ?></span>
			  </div>
			  

			  <div class="form-group">
				<label for="life_group_id">Group:</label>
					<select name="life_group_id" class="custom-select">						
						<?php
						$GroupIDStmt = $con->prepare("SELECT * FROM groups");
						$GroupIDStmt->execute(array());
						while($GroupRow = $GroupIDStmt->fetch(PDO::FETCH_ASSOC)) {
							$isSelected = "";
							if($GroupRow['GroupID'] == $GroupID){
								$isSelected = "selected";
							}
							echo "<option value=".$GroupRow['GroupID']." $isSelected>".$GroupRow['GroupName']."</option>";
						}
						?>
					</select>
				</div>

			  <div class="form-group">
				<label for="home_address">Home Address:</label>
				<input type="text" class="form-control" id="home_address" value="<?php echo $HomeAddress; ?>" placeholder="Enter home address" name="home_address" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $home_address_error; ?></span>
			  </div>

			  <div class="form-group">
				<label for="prayer_request">Prayer Request:</label>
				<input type="text" class="form-control" id="prayer_request" value="<?php echo $PrayerRequest; ?>" placeholder="Enter prayer request" name="prayer_request">
			  </div>

				<div class="form-group form-check">
					<label class="form-check-label"></label>
						<input class="form-check-input" type="checkbox" name="opt_text" <?php echo $opt_phone_checked; ?>>Opt in for text notifications
					</label>
				</div>

				<div class="form-group form-check">
					<label class="form-check-label"></label>
						<input class="form-check-input" type="checkbox" name="opt_email" <?php echo $opt_email_checked; ?>>Opt in for email notifications
					</label>
				</div>
				<span class="help-block"><?php echo $any_error; ?></span>
			  <button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
	<script src="edit_member.js"></script>
</div>
</body>
</html>