<?php
    include 'header.php';
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: dashboard.php");
        exit;
    }

    require_once "config.php";
    $email = "";
    $password = "";

    $email_error = "";
    $password_error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){//here after clicking submit on login page
        
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
            $sql = "SELECT id, email, password FROM admins WHERE email = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                
                $param_email = $email;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["email"] = $email;                            
                                
                                header("location: dashboard.php");
                            } else{
                                
                                $password_error = "The password you entered was not valid.";
                            }
                        }
                    } else{
                        
                        $email_error = "No account found with that username.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
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
			  <button type="submit" class="btn btn-primary">Log In</button>
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<button type="submit" class="btn btn-secondary">Forgot Password</button>
		</div>
	</div>
	<script src="login.js"></script>
</div>
</body>
</html>
