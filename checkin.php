<?php 
include 'header.php';
?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Check In</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="/action_page.php" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
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
