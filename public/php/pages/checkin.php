<?php
include '../phpInc/header.php';
session_verify();
require_once "../phpUtil/db_query.php";

// Check if date is set
if(isset($_SESSION['checkinDate'])) $date = $_SESSION['checkinDate'];
else
{
	Header("Location: logout.php");
	exit;
}

// Get list of lifegroups from DB
$lifegroups = '<option>- -</option>';

$dbquery = new db_query();
$rawLG = $dbquery->life_group_check("LifeGroupActive", '1');
foreach($rawLG as $lifegroup)
{
		$lifegroups .= '<option>' . $lifegroup['LifeGroupName'] . '</option>';
}

?>

<body>
	<!-- Modal -->
	<div id="checkInModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header d-block">
			<button type="button" name='modal-close' class="close float-right" data-dismiss="modal">&times;</button>
	        <h2 class="modal-title text-center" id="modal-title"></h2>
	      </div>
	      <div class="modal-body text-center">

					<!-- Display the original section -->
					<div id="displayData" class="collapse show">
						<h4>Is the following info correct?</h4>
						<br>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Name: </div>
							<div id="name" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1" style="margin-right: 0">Email: </div>
							<div id="email" class="col text-left px-lg-1" style="margin-left: 0"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Phone Number: </div>
							<div id="phoneNumber" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Status: </div>
							<div id="status" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Major: </div>
							<div id="major" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Life Group: </div>
							<div id="life-groups" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Opt Into Emails: </div>
							<div id="optEmail" class="col text-left px-lg-1"></div>
						</div>
						<div class="row no-gutters mx-lg-n1">
							<div class="displayData col text-right px-lg-1">Opt Into Texts: </div>
							<div id="optText" class="col text-left px-lg-1"></div>
						</div>
						<br>

						<!-- Verification buttons -->
						<button type="button" class="btn btn-primary" id="confirmInfo">Yes!</button>
						<button type="button" class="btn btn-primary" id="editMemberBtn">No, I need to edit</button>
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
						<br>
						<button type="button" class="btn btn-primary" id="signUp">Sure!</button>
						<button type="button" class="btn btn-primary" id="noThanks">No Thanks</button>
					</div>

					<!-- Display the showLifeGroups section -->
					<div id="showLifeGroups" class="collapse">
						<h4>Great! Select one of our Life Groups Below</h4>
						<br>
						<select id="selectLifeGroups" class="form-control w-50 mx-auto"><?php echo $lifegroups; ?></select>
						<br>
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
						<h4>All done, grab a nametag! We're glad you're here.</h4>
					</div>

					<!-- Edit member -->
					<div id="editMember" class="collapse">
						<div class="row justify-content-center">
							<h4>Select which parts you need to edit.</h4>
						</div>
						<br>
						<form class='needs-validation' name='editForm'>
						<div class="form-horizontal">

							<!-- First Name -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editFirstName" class="col-form-label">First Name</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control inputToggle editFirstName" name="editFirstName" disabled required>
									<div class="invalid-feedback">Must enter a first name</div>
								</div>
								<button type="button" class="btn-sm btn btn-secondary editToggle" id="editFirstName" name="btnEditFirstName">Edit</button>
							</div>

							<!-- Last Name -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editLastName" class="col-form-label">Last Name</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control inputToggle editLastName" name="editLastName" disabled required>
									<div class="invalid-feedback">Must enter a last name</div>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editLastName" name="btnEditLastName">Edit</button>
							</div>

							<!-- Email -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editEmail" class="col-form-label">Email</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control inputToggle editEmail" name="editEmail" disabled required>
									<div class="invalid-feedback" for="editEmail" name='editInvalid'>Invalid Email</div>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editEmail" name="btnEditEmail">Edit</button>
							</div>

							<!-- Phone Number -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editPhone" class="col-form-label">Phone</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control inputToggle editPhone" name="editPhone" disabled required>
									<div class='invalid-feedback' name='editPhone'>Invalid Phone</div>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editPhone" name="btnEditPhone">Edit</button>
							</div>

							<!-- Status -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editStatus" class="col-form-label">Status</label>
								</div>
								<div class="col-8">
									<select class="form-control inputToggle editStatus" name="editStatus" disabled required>
										<option val="Freshman">Freshman</option>
										<option val="Sophomore">Sophomore</option>
										<option val="Junior">Junior</option>
										<option val="Senior">Senior</option>
										<option val="Graduate">Graduate</option>
										<option val="Alumni">Alumni</option>
										<option val="Staff">Staff</option>
										<option val="Other">Other</option>
									</select>
									<div class='invalid-feedback'>Must select a status</div>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editStatus" name="btnEditStatus">Edit</button>
							</div>

							<!-- Major -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editMajor" class="col-form-label">Major (or N/A)</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control inputToggle editMajor" name="editMajor" disabled required>
									<div class='invalid-feedback'>Must enter a major</div>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editMajor" name="btnEditMajor">Edit</button>
							</div>

							<!-- Life Groups -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="editLifeGroup" class="col-form-label">Life Group</label>
								</div>
								<div class="col-8">
									<select class="form-control inputToggle editLifeGroup" name="editLifeGroup" disabled>
										<?php echo $lifegroups; ?>
									</select>
								</div>
								<button type="button" class="btn btn-sm btn-secondary editToggle" id="editLifeGroup" name="btnEditLifeGroup">Edit</button>
							</div>

							<!-- Opt Emails Opt Texts -->
							<div class="form-row form-group justify-content-center">
								<div class="form-check form-check-inline">
									<input type="checkbox" name="checkOptEmail" class="form-check-input checkin-opt-checkbox">
									<label class="form-check-label col-form-label" for="checkOptEmail">Opt Into Emails</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="checkbox" name="checkOptTexts" class="form-check-input checkin-opt-checkbox">
									<label class="form-check-label col-form-label" for="checkOptTexts">Opt Into Texts</label>
								</div>
							</div>

							<div class="form-row form-group justify-content-center">
								<div class="col-5">
									<button type="button" class="btn btn-primary" id="saveEditMember">Confirm Changes</button>
									<button type="button" class="btn btn-primary" id="cancelEditMember">Cancel</button>
								</div>
							</div>
						</div>
					</div>

					<!-- Registration Page -->
					<div class="collapse show" id="registerModal">
						<form class='needs-validation'>
						<div class="form-horizontal">

							<!-- First Name -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label for="regFirst" class="col-form-label">First Name</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="regFirst" placeholder="First Name" required>
									<div class='invalid-feedback'>Must enter a first name</div>
								</div>
							</div>

							<!-- Last Name -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label class="col-form-label">Last Name</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="regLast" placeholder="Last Name" required>
									<div class='invalid-feedback'>Must enter last name</div>
								</div>
							</div>

							<!-- Email -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label class="col-form-label">Email</label>
								</div>
								<div class="col-8">
									<input type="email" class="form-control" name="regEmail" placeholder="Email" required>
									<div class='invalid-feedback'>Invalid Email</div>
								</div>
							</div>

							<!-- Phone Number -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label class="col-form-label">Phone Number</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="regPhone" placeholder="Phone Number" required>
									<div class='invalid-feedback' name='regPhone'>Invalid Phone</div>
								</div>
							</div>

							<!-- Status -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label class="col-form-label" for="regStatus">Status</label>
								</div>
								<div class="col-8">
									<select class="form-control" name="regStatus" required>
										<option val="Freshman">Freshman</option>
										<option val="Sophomore">Sophomore</option>
										<option val="Junior">Junior</option>
										<option val="Senior">Senior</option>
										<option val="Graduate">Graduate</option>
										<option val="Alumni">Alumni</option>
										<option val="Staff">Staff</option>
										<option val="Other">Other</option>
									</select>
								</div>
							</div>

							<!-- Major -->
							<div class="form-row form-group justify-content-center">
								<div class="col-2">
									<label class="col-form-label" for="regMajor">Major (or N/A)</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="regMajor" placeholder="Major" required>
									<div class='invalid-feedback'>Must enter major</div>
								</div>
							</div>

							<!-- Opt Emails Opt Texts-->
							<div class="form-row form-group justify-content-center">
								<div class="form-check form-check-inline">
									<input type="checkbox" name="regOptEmail" class="form-check-input checkin-opt-checkbox">
									<label class="form-check-label col-form-label" for="regOptEmail">Opt Into Emails</label>
								</div>
								<div class="form-check form-check-inline">
									<input type="checkbox" name="regOptTexts" class="form-check-input checkin-opt-checkbox">
									<label class="form-check-label col-form-label" for="regOptTexts">Opt Into Texts</label>
								</div>
							</div>

							<div class="form-row form-group justify-content-center">
								<button type="button" name="register" class="btn btn-primary">Register</button>
							</div>
						</div>
					</form>
					</div>
				</form>
	      </div>

	      <div class="modal-footer">

	      </div>
	    </div>

	  </div>
	</div>

<div class="jumbotron text-center" style="margin-bottom:0">
	<img src="../../img/logo.png" class="img-fluid" alt="Responsive image" width="700px" height="394px">
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
</nav>

<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<form class="needs-validation" novalidate>
			  <div class="form-group">
					<label for="tel" required>Been here before? Enter your phone number to sign in: </label>
					<input type="tel" class="form-control input-medium bfh-phone" id="phone" placeholder="(xxx)-xxx-xxxx" pattern="[0-9]{10}" name="phone" autocomplete="off" required>
					<div class="invalid-feedback">Oops! We don't have your phone number... Try registering below!</div>
					<br>

					<!-- Check in button opens modal -->
					<button type="button" id="checkIn" class="btn btn-primary">Check In</button>

					<!-- Register button opens registration modal -->
					<button type="button" id="register" class="btn btn-primary">First Time? Register Here!</button>
			  </div>
			</form>
			<a href="logout.php">Logout</a>
		</div>
	</div>
	<script src="../../js/checkin.js"></script>
</div>
</body>
</html>
