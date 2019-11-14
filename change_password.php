<?php 
include 'header.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";

$new_password = $confirm_password = "";
$new_password_error = $confirm_password_error = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
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
        
    
    if(empty($new_password_error) && empty($confirm_password_error)){
        // Prepare an update statement
        $sql = "UPDATE admins SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Change Password</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="" method="post" class="needs-validation" novalidate>
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
			  <button type="submit" class="btn btn-primary">Change Password</button>
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<button type="submit" class="btn btn-secondary">Back</button>
		</div>
	</div>
	<script>
	// Disable form submissions if there are invalid fields
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
		// Get the forms we want to add validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
		  form.addEventListener('submit', function(event) {
			if (form.checkValidity() === false) {
			  event.preventDefault();
			  event.stopPropagation();
			}
			form.classList.add('was-validated');
		  }, false);
		});
	  }, false);
	})();
	</script>
</div>
</body>
</html>
