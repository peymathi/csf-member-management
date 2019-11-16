<?php 
include 'header.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	header("location: login.php");
	exit;
}

require_once "config.php";
$first_name = "";
$last_name = "";
$email = "";
$phone_number = "";
$graduation_date = "";
$major = "";
$life_group_id = "";
$opt_phone = 0;//default 0 = no
$opt_email = 0;//default 0 = no
$home_address = "";
$prayer_request = "";

$first_name_error = "";
$last_name_error = "";
$email_error = "";
$phone_number_error = "";
$graduation_date_error = "";
$major_error = "";
$life_group_error = "";
$home_address_error = "";

$any_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){//here after clicking submit on login page
	
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
		$life_group_error = "Must enter life group.";
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
		$sql = "INSERT INTO members(FirstName, LastName, EmailAddress, HomeAddress, PhoneNumber, PrayerRequest, OptEmail, OptText) VALUES (?,?,?,?,?,?,?,?)";
		//$sql = "SELECT id, email, password FROM admins WHERE email = ?";
		//$sql = "INSERT INTO members(FirstName, LastName, EmailAddress, HomeAddress, PhoneNumber, OptEmail, OptText, GroupID) VALUES (?,?,?,?,?,?,?,?)";

		if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "ssssssii", $param_first_name, $param_last_name, $param_email, $param_home_address, $param_phone_number, $param_prayer_request, $param_opt_phone, $param_opt_email);//, $param_group_id);
			
			$param_first_name = $first_name;
			$param_last_name = $last_name;
			$param_email = $email;
			$param_home_address = $home_address;
			$param_phone_number = $phone_number;
			$param_opt_phone = $opt_phone;
			$param_opt_email = $opt_email;
			$param_prayer_request = $prayer_request;
			//$param_group_id = 1;//not wekin rn
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				echo "User successfully entered.";
				//header("location: dashboard.php");
			} else{
				echo mysqli_error($link);
				echo "\nOops! Something went wrong. Please try again later.";
			}
		}
		
		mysqli_stmt_close($stmt);
	}
	
	mysqli_close($link);
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
				<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $email_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="first_name">First Name:</label>
				<input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $first_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="last_name">Last Name:</label>
				<input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $last_name_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="phone_number">Phone Number:</label>
				<input type="text" class="form-control" id="phone_number" placeholder="Enter phone number" name="phone_number" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $phone_number_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="major">Major:</label>
				<input type="text" class="form-control" id="major" placeholder="Enter major" name="major" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $major_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="graduation_date">Graduation Date:</label>
				<input type="text" class="form-control" id="graduation_date" placeholder="Enter graduation date" name="graduation_date" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $graduation_date_error; ?></span>
			  </div>
			  <div class="form-group">
				<label for="life_group_id">Life Group:</label>
				<input type="number" class="form-control" id="life_group_id" placeholder="Enter life group id" name="life_group_id" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $life_group_error; ?></span>
			  </div>

			  <div class="form-group">
				<label for="home_address">Home Address:</label>
				<input type="text" class="form-control" id="home_address" placeholder="Enter home address" name="home_address" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $home_address_error; ?></span>
			  </div>

			  <div class="form-group">
				<label for="prayer_request">Prayer Request:</label>
				<input type="text" class="form-control" id="prayer_request" placeholder="Enter prayer request" name="prayer_request">
			  </div>

				<div class="form-group form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" value="1" name="opt_phone">Opt in for text notifications.
					</label>
				</div>

				<div class="form-group form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" value="1" name="opt_email">Opt in for email notifications.
					</label>
				</div>
			  <button type="submit" class="btn btn-primary">Register</button>
			</form>
		</div>
	</div>
	<script src="register.js"></script>
</div>
</body>
</html>
