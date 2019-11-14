<?php
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Student Check In</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Reports</a>
      </li>    
    </ul>  
</nav>

<div class="container" style="margin-top:30px">
  <div class="row">
    
    <div class="col">
	
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td>John</td>
				<td>Doe</td>
				<td>john@example.com</td>
			  </tr>
			  <tr>
				<td>Mary</td>
				<td>Moe</td>
				<td>mary@example.com</td>
			  </tr>
			  <tr>
				<td>July</td>
				<td>Dooley</td>
				<td>july@example.com</td>
			  </tr>
			</tbody>
		  </table>
	
	
     </div>
  </div>
</div>

</body>
</html>
