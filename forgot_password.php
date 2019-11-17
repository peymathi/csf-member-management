<?php 
include 'header.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	header("location: dashboard.php");
	exit;
}

require_once "config.php";

$email = "";

$email_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(empty(trim($_POST["email"]))){
		$email_error = "Must enter email.";
	} else {
		$email = trim($_POST["email"]);
	}

	if(empty($email_error)){
		//$sql = "SELECT id, email, password FROM admins WHERE email = ?";

		$sql = "UPDATE admins SET password = ? WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_email);

			$newpassword = randomPassword();//unhashed
			$param_password = password_hash($newpassword, PASSWORD_DEFAULT);
			$param_email = $email;
			
			if(mysqli_stmt_execute($stmt)){
				
				echo $newpassword;
				$to = $email;
				$subject = "Password Reset";
                $txt = "Your new password is : $newpassword";
                $headers = "From: test@test.com";
                mail($to,$subject,$txt,$headers);
				
			} else{
				//echo "Oops! Something went wrong. Please try again later.";
			}
			echo "An email was sent if there is a user with that email.";
		}
		
		mysqli_stmt_close($stmt);
	}
	
	mysqli_close($link);
}


function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Forgot Password</h1>
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
			  <button type="submit" class="btn btn-primary">Reset</button>
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<a href="login.php">
				<button type="submit" class="btn btn-secondary">Back To Log In</button>
			</a>
		</div>
	</div>
	<script src="forgot_password.js"></script>
</div>
</body>
</html>
