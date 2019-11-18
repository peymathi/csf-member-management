<?php
include 'header.php';
include "phpUtil/sessionVerification.php";
session_verify();


require_once "config.php";
$first_name = "";
$last_name = "";
$email = "";
$phone_number = "";
$graduation_date = "";
$major = "";
$life_group_id = null;
$opt_phone = 0;//default 0 = no
$opt_email = 0;//default 0 = no
$home_address = "";
$prayer_request = "";

$opt_email_checked="";
$opt_phone_checked="";

$first_name_error = "";
$last_name_error = "";
$email_error = "";
$phone_number_error = "";
$graduation_date_error = "";
$major_error = "";
$life_group_error = "";
$home_address_error = "";

$any_error = "";

//temporary for testing
$_SESSION["edit_member_id"] = "12";
//

if(isset($_SESSION["edit_member_id"])){

	$edit_member_id = $_SESSION["edit_member_id"];

	$sql = "SELECT FirstName, LastName, EmailAddress, HomeAddress, PhoneNumber, PrayerRequest, OptEmail, OptText, GroupID FROM members WHERE MemberID = $edit_member_id";

	$result = mysqli_query($link, $sql);
	if($result){

		while ($row = mysqli_fetch_array($result)) {

			$first_name = $row['FirstName'];
			$last_name = $row['LastName'];
			$email = $row['EmailAddress'];
			$phone_number = $row['PhoneNumber'];
			//$graduation_date = $row['name'];
			//$major = $row['name'];
			$life_group_id = $row['GroupID'];
			$opt_phone = $row['OptText'];//default 0 = no

			if($opt_phone == "1"){
				$opt_phone_checked="checked";
			}

			$opt_email = $row['OptEmail'];//default 0 = no

			if($opt_email == "1"){
				$opt_email_checked="checked";
			}

			$home_address = $row['HomeAddress'];
			$prayer_request = $row['PrayerRequest'];

		}

	}else{
		echo $link->error;
	}


}else{//no user to edit
	header("location: dashboard.php");
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
		$first_name = trim($_POST["first_name"]);
	}

	if(empty(trim($_POST["last_name"]))){
		$last_name_error = "Must enter last name.";
	} else {
		$last_name = trim($_POST["last_name"]);
	}

	if(empty(trim($_POST["phone_number"]))){
		$phone_number_error = "Must enter phone number.";
	} else {
		$phone_number = trim($_POST["phone_number"]);
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
		$life_group_id = null;
	} else {
		$life_group_id = trim($_POST["life_group_id"]);
	}

	if(empty(trim($_POST["home_address"]))){
		$home_address_error = "Must enter home address.";
	} else {
		$home_address = trim($_POST["home_address"]);
	}

	if(isset($_POST["opt_phone"])){
		$opt_phone = 0;//if empty 0 means no
	} else {
		$opt_phone = 1;
	}

	if(isset($_POST["opt_email"])){
		$opt_email = 0;//if empty 0 means no
	} else {
		$opt_email = 1;
	}

	if(empty(trim($_POST["prayer_request"]))){
		$prayer_request = "";
	} else {
		$prayer_request = trim($_POST["prayer_request"]);
	}

	if(
	!empty($email_error) ||
	!empty($first_name_error) ||
	!empty($last_name_error) ||
	!empty($phone_number_error) ||
	!empty($major_error) ||
	!empty($graduation_date_error) ||
	!empty($home_address_error) ||
	!empty($life_group_error)//if any of these errors are not empty, then don't add anything to db
	)
	{
		$any_error = "errors";
	}

	//INSERT INTO `members`(`FirstName`, `LastName`, `EmailAddress`, `HomeAddress`, `PhoneNumber`, `OptEmail`, `OptText`, `GroupID`) VALUES ([value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])


	if(empty($any_error)){
		//$sql = "INSERT INTO members(FirstName, LastName, EmailAddress, HomeAddress, PhoneNumber, PrayerRequest, OptEmail, OptText) VALUES (?,?,?,?,?,?,?,?)";

		$sql = "UPDATE members set FirstName='$first_name', LastName='$last_name', EmailAddress='$email', HomeAddress='$home_address', PhoneNumber='$phone_number', PrayerRequest='$prayer_request', OptEmail='$opt_email', OptText='$opt_phone' WHERE MemberID=$edit_member_id";

		$result = mysqli_query($link, $sql);
		if($result){
			header("location: checkin.php");
		}else{
			echo $link->error;
		}


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
				<input type="email" class="form-control" id="email" value="<?php echo $email; ?>" placeholder="Enter email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $email_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="first_name">First Name:</label>
				<input type="text" class="form-control" id="first_name" value="<?php echo $first_name; ?>" placeholder="Enter first name" name="first_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $first_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="last_name">Last Name:</label>
				<input type="text" class="form-control" id="last_name" value="<?php echo $last_name; ?>" placeholder="Enter last name" name="last_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $last_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="phone_number">Phone Number:</label>
				<input type="text" class="form-control" id="phone_number" value="<?php echo $phone_number; ?>" placeholder="Enter phone number" name="phone_number" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $phone_number_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="major">Major:</label>
				<input type="text" class="form-control" id="major" value="<?php echo $major; ?>" placeholder="Enter major" name="major" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $major_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="graduation_date">Graduation Date:</label>
				<input type="text" class="form-control" id="graduation_date" value="<?php echo $graduation_date; ?>" placeholder="Enter graduation date" name="graduation_date" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $graduation_date_error; ?></span>
			  </div>


			  <div class="form-group">
				<label for="life_group_id">Group:</label>
					<select name="life_group_id" class="custom-select">
						<option <?php if($life_group_id==null){echo "selected";}?>>None</option>

						<?php

							$sql = "SELECT * FROM groups WHERE GroupID > 0";

							$result = mysqli_query($link, $sql);
							if($result){

								while ($row = mysqli_fetch_array($result)) {
									$isSelected = "";
									echo $row['GroupID'] . " = " . $life_group_id;
									if($row['GroupID'] == $life_group_id){
										$isSelected = "selected";
									}

									echo "<option value=".$row['GroupID']." $isSelected>".$row['GroupName']."</option>";

								}

							}else{
								echo $link->error;
							}
						?>
					</select>
				</div>




			  <div class="form-group">
				<label for="home_address">Home Address:</label>
				<input type="text" class="form-control" id="home_address" value="<?php echo $home_address; ?>" placeholder="Enter home address" name="home_address" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $home_address_error; ?></span>
			  </div>

			  <div class="form-group">
				<label for="prayer_request">Prayer Request:</label>
				<input type="text" class="form-control" id="prayer_request" value="<?php echo $prayer_request; ?>" placeholder="Enter prayer request" name="prayer_request">
			  </div>

				<div class="form-group form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" value="1" name="opt_phone" <?php echo $opt_phone_checked; ?>>Opt in for text notifications.
					</label>
				</div>

				<div class="form-group form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" value="1" name="opt_email" <?php echo $opt_email_checked; ?>>Opt in for email notifications.
					</label>
				</div>
			  <button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
	<script src="edit_member.js"></script>
</div>
</body>
</html>
