<?php
include 'header.php';
session_verify();
require_once "db_connect.php";



?>

<body>

	<div id="hi" hidden>
		<p>Hi im paul</p>
	</div>

	<!-- Modal -->
	<div id="checkInModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header d-block">
					<button type="button" class="close float-right" data-dismiss="modal">&times;</button>
	        <h2 class="modal-title text-center" id="modal-title"></h2>
	      </div>
	      <div class="modal-body text-center">

					<!-- Display the original section -->
					<div id="displayData" class="collapse">
						<h4>Is the following info correct?</h4>
						<br>
						<p id="name">Name: </p>
						<p id="email">Email: </p>
						<p id="phoneNumber">Phone Number: </p>
						<p id="status"></p>
						<p id="major">Major:</p>
						<p id="life-groups">LifeGroup:</p>
						<p id="optEmail"></p>
						<p id="optText"></p>

						<!-- Verification buttons -->
						<button type="button" class="btn btn-primary" id="confirmInfo">Yes!</button>
						<button type="button" class="btn btn-primary" id="editMember">No, I need to edit</button>
					</div>

					<!-- Display the prayer request section -->
					<div id="prayerRequest" class="collapse">
						<h4>How can we pray for you?</h4>
						<textarea class="form-control h-75" name="prayerRequestInput"></textarea>
						<br>
						<button type="button" class="btn btn-primary" id="finishPrayer">Finish Check In</button>
					</div>

					<!-- Display the asklifegroups section -->
					<div id="askLifeGroups" class="collapse">
						<h4>Would you like to sign up for a Life Group today?</h4>
						<button type="button" class="btn btn-primary" id="signUp">Sure!</button>
						<button type="button" class="btn btn-primary" id="noThanks">No Thanks</button>
					</div>

					<!-- Display the showLifeGroups section -->
					<div id="showLifeGroups" class="collapse">
						<h4>Great! Select one of our Life Groups Below</h4>
						<select id="selectLifeGroups">
						</select>
						<button type="button" class="btn btn-primary" id="signUpConfirm">Sign Me Up!</button>
						<button type="button" class="btn btn-primary" id="decline">Not at this time</button>
					</div>

					<!-- Display Life group confirmation section -->
					<div id="confirmLifeGroup" class="collapse">
						<h4>Thanks for signing up!</h4>
						<p>We'll reach out to you shortly with more information about your Life Group.</p>
					</div>

					<!-- Display the end of the form -->
					<div id="finishForm" class="collapse">
						<h4>All done! Grab a nametag. We're glad you're here.</h4>
					</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Night of Worship Check In</h1>
</div>

<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form action="checkin.php" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
					<label for="tel" required>Been here before? Enter your phone number to sign in: </label>
					<input type="tel" class="form-control input-medium bfh-phone" id="phone" placeholder="(xxx)-xxx-xxxx" pattern="[0-9]{10}" name="phone" autocomplete="off" required>
					<span class="form-text d-none">Oops! We don't have your phone number... Try registering below!</span>
					<br>
					<div class="valid-feedback">Valid.</div>
					<div class="invalid-feedback">Please fill out this field.</div>

					<!-- Check in button opens modal -->
					<button type="button" id="checkIn" class="btn btn-primary">Check In</button>
			  </div>
				<a href="register.php">First Time? Click Here to Register!</a>
			</form>
			<a href="logout.php">Logout</a>
		</div>
	</div>
	<script src="js/checkin.js"></script>
</div>
</body>
</html>
