<?php
include 'header.php';

require_once "phpUtil/db_connect.php";
session_verify();

$email = $new_password = $confirm_password = "";
$email_error = $new_password_error = $confirm_password_error = "";

if(isset($_POST['change'])){
	if(empty(trim($_POST["email"]))){
        $email_error = "Please enter the Email.";
    } elseif(strlen(trim($_POST["email"])) < 6){
        $email_error = "Password must have atleast 6 characters.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["new_password"]))){
        $new_password_error = "Please enter the new password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_error = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_error) && ($new_password != $confirm_password)){
            $confirm_password_error = "Password did not match.";
        }
    }

    if(empty($email_error) && empty($new_password_error) && empty($confirm_password_error)){
        //Prepare an update statement
		$passwordStmt = $con->prepare('UPDATE admins SET password = :password WHERE email = :email');
		$newPassword = password_hash($new_password, PASSWORD_DEFAULT);
		$passwordStmt->execute(array('password'=>$newPassword, 'email'=>$email));
		Header("Location: dashboard.php");
    }
}
?>

<div class="jumbotron text-center" style="margin-bottom:0">
	<img src="img/logo.png" class="img-fluid" alt="Responsive image" width='200px' height='200px'>
  <h1>Change Password</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <span class="help-block"><?php echo $email_error; ?></span>
			  <div class="form-group">
				<label for="new_password">New Password:</label>
				<input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <span class="help-block"><?php echo $new_password_error; ?></span>
			  <div class="form-group">
				<label for="confirm_password">Confirm New Password:</label>
				<input type="password" class="form-control" id="confirm_password" placeholder="Confirm new password" name="confirm_password" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <span class="help-block"><?php echo $confirm_password_error; ?></span>
			  <button type="submit" class="btn btn-primary" name="change">Change Password</button>
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
            <a href="dashboard.php">
			    <button type="submit" class="btn btn-secondary">Back</button>
            </a>
		</div>
	</div>
	<script src="change_password.js"></script>
</div>
</body>
</html>
