<?php
include 'header.php';
include 'phpUtil/sessionVerification.php';
require_once "db_connect.php";

// Verify the session
session_verify();
$inactive = (isInactive()) ? "You were logged out due to inactivity" : "";

$email = "";
$password = "";

$email_error = "";
$password_error = "";


if(isset($_POST['login'])){//here after clicking submit on login page
	if(empty(trim($_POST["email"]))){
		$email_error = "Must enter email.";
	} else {
		$email = trim($_POST["email"]);
	}
	if(empty(trim($_POST["password"]))){
		$password_error = "Must enter password.";
	} else {
		$password = trim($_POST["password"]);
	}
	if(empty($email_error) && empty($password_error)){
		$loginStmt = $con->prepare('SELECT firstname, lastname, email, password FROM admins WHERE email = :email');
		$loginStmt->execute(array('email'=>$email));
		$row = $loginStmt->fetch(PDO::FETCH_OBJ);
		if($loginStmt->rowCount() != 1){
			$email_error = "Login Unsuccessful. Please Try Another Email.";
		}else{
			if(password_verify($password, $row->password)){
				// Authenticate user
				authenticate();
			}else{
				$password_error = "Login Unsuccessful. Please Try Another Password.";
			}
		}
	}
}

if(isset($_POST['forgot'])){
	Header("Location: forgot_password.php");
}
?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
  <span><?php echo $inactive; ?></span>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>" required>
                <span class="help-block"><?php echo $email_error; ?></span>
                <div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                <span class="help-block"><?php echo $password_error; ?></span>
                <div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <button type="submit" class="btn btn-primary" name="login">Log In</button>
			  <button type="submit" class="btn btn-secondary" name="forgot">Forgot Password</button>
			</form>
		</div>
	</div>
	<script src="login.js"></script>
</div>
</body>
</html>
