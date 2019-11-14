<?php 
include 'header.php';
?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="/action_page.php" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="uname">Email:</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="fname">First Name:</label>
				<input type="text" class="form-control" id="fname" placeholder="Enter first name" name="fname" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="lname">Last Name:</label>
				<input type="text" class="form-control" id="lname" placeholder="Enter last name" name="lname" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="phonenumber">Phone Number:</label>
				<input type="text" class="form-control" id="phonenumber" placeholder="Enter phone number" name="phonenumber" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="major">Major:</label>
				<input type="text" class="form-control" id="major" placeholder="Enter major" name="major" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="graduationdate">Graduation Date:</label>
				<input type="text" class="form-control" id="graduationdate" placeholder="Enter graduation date" name="graduationdate" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <div class="form-group">
				<label for="lifegroup">Life Group:</label>
				<input type="text" class="form-control" id="lifegroup" placeholder="Enter life group" name="lifegroup" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
			  </div>
			  <button type="submit" class="btn btn-primary">Register</button>
			</form>
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
