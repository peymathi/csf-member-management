<?php
include 'header.php';
session_verify();

require_once "db_connect.php";
$phone = "";

$phone_error = "";

$UserCheckin = new UserCheckin();


if(isset($_POST['edit']))
{
	// Validate phone input
	if(empty(trim($_POST["phone"])))
		$phone_error = "Must enter phone Number in format: (xxx)-xxx-xxxx.";
	else $phone = trim($_POST["phone"]);

	if(empty($phone_error))
	{
		$checkinStmt = $con->prepare('SELECT * FROM members WHERE PhoneNumber = :phone');
		$checkinStmt->execute(array('phone'=>$phone));

		if($checkinStmt->rowCount() != 1)
			$phone_error = "Oops! We don't have your phone number on record. Please try again.";

		else
		{
			$row = $checkinStmt->fetch(PDO::FETCH_OBJ);
			$UserCheckin->setMemberID($row->MemberID);
			$UserCheckin->setFirstName($row->FirstName);
			$UserCheckin->setLastName($row->LastName);
			$UserCheckin->setEmailAddress($row->EmailAddress);
			$UserCheckin->setHomeAddress($row->HomeAddress);
			$UserCheckin->setPhoneNumber($row->PhoneNumber);
			$UserCheckin->setPhotoPath($row->PhotoPath);
			$UserCheckin->setPrayerRequest($row->PrayerRequest);
			$UserCheckin->setOptEmail($row->OptEmail);
			$UserCheckin->setOptText($row->OptText);
			$UserCheckin->setGroupID($row->GroupID);
			$_SESSION["UserCheckin"] = $UserCheckin;
			Header("Location:edit_member.php");
		}
	}
}

?>

<body>

	<!-- Modal -->
	<div id="checkInModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Modal Header</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">

					<!-- Display the original section -->
					<div id="displayData" hidden>
					</div>

					<!-- Display the prayer request section -->
					<div id="prayerRequest" hidden>
					</div>

					<!-- Display the lifegroups section -->
					<div id="lifeGroups" hidden>
					</div>

					<!-- Display the end of the form -->
					<div id="finishForm" hidden>
					</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
					<input type="tel" class="form-control input-medium bfh-phone" id="phone" placeholder="(xxx)-xxx-xxxx" pattern="[0-9]{10}" name="phone" required>
					<span class="help-block"><?php echo $phone_error; ?></span>
					<br>
					<div class="valid-feedback">Valid.</div>
					<div class="invalid-feedback">Please fill out this field.</div>

					<!-- Check in button opens modal -->
					<button type="button" name="checkIn" class="btn btn-primary" data-toggle="modal" data-target="#checkInModal">Check In</button>
			  </div>
				<a href="register.php">First Time? Click Here to Register!</a>
			</form>
			<a href="logout.php">Logout</a>
		</div>
	</div>
	<script src="checkin.js"></script>
</div>
</body>
</html>
