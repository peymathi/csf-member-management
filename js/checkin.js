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

function cleanUpPhone(phone)
{

	phone = phone.replace(/[()-]/g, "");
	phone = phone.replace(/\s/g, "");
	return phone;
}

function validateEmail(email)
{
	if (email.indexOf('@') < 0) return false;
	else if (email.indexOf('.') < 0) return false;
	else return true;
}

function validatePhone(phone)
{
	phone = cleanUpPhone(phone);
	if (isNaN(phone)) return false;
	else if (phone.length < 10) return false;
	else if (phone.length > 11) return false;
	else return true;
}

function ajaxError()
{
		alert("Server connection failure. Please check your internet connection");
}

// First state of the modal
function checkIn(userData)
{
	$("#displayData").collapse("show");
	$("#modal-title").text("Welcome Back " + userData.FirstName + "!");

	// Display user's data
	$("#name").text(" " + userData.FirstName  + " " + userData.LastName);
	$("#email").text(" " + userData.Email);
	$("#phoneNumber").text(userData.Phone);
	$("#status").text(userData.Status);
	$("#major").text(userData.Major);
	$("#life-groups").text( userData.LifeGroup);
	$("#optEmail").text((userData.OptEmail ? "Yes" : "No"));
	$("#optText").text((userData.OptText ? "Yes" : "No"));
}

// Runs after user verifies their info.
function continueForm(userData)
{
	// Hide the old page
	$("#displayData").collapse("hide");
	$("#editMember").collapse("hide");

	// Check if the user is not in a lifegroup
	if (userData.LifeGroup === "None")
	{
		$("#askLifeGroups").collapse("show");
	}

	// Continue straight to prayer request
	else
	{
		$("#prayerRequest").collapse("show");
	}
}

// Runs if the user chooses to view lifegroups
function displayLifegroups(userData)
{
	$("#askLifeGroups").collapse("hide");

	$("#showLifeGroups").collapse("show");
}

// Receives the lifegroups form
function finishLifeGroups(userData)
{
	var lifegroup = $("#selectLifeGroups").val();

	// Update user object
	if (lifegroup != '- -')
	{
		userData.LifeGroup = lifegroup;
	}

	// Close the lifegroups divs
	$("#showLifeGroups").collapse("hide");
	$("#askLifeGroups").collapse("hide");

	// Open prayer request div
	$("#prayerRequest").collapse("show");
}

// Runs once the user has finished checking in
function finishForm(userData)
{
	$("#prayerRequest").collapse("hide");
	$("#finishForm").collapse("show");

	// Get prayer request
	userData.PrayerRequest = $("textarea[name='prayerRequestInput']").val();

	// Make ajax call to push new user data to DB
	$.ajax({
		url: 'phpAjax/finishCheckIn.php',
		method: 'POST',
		data: userData,
		error: function() { ajaxError(); },
		success: function(data) {
			// Delay for 5 seconds and then link back to original check in page
			setTimeout(function(){
				location.reload();
			}, 5000);
		}
	});
}

// Function that runs when a user wants to edit info
function editMember(userData)
{
	$("#displayData").collapse("hide");
	$("#editMember").collapse("show");

	// Fill out form elements with user info
	$("input[name='editFirstName']").val(userData.FirstName);
	$("input[name='editLastName']").val(userData.LastName);
	$("input[name='editEmail']").val(userData.Email);
	$("input[name='editPhone']").val(userData.Phone);
	$("select[name='editStatus']").val(userData.Status);
	$("input[name='editMajor']").val(userData.Major);

	// Select user's lifegroup in select element
	$("select[name='editLifeGroup'] option:contains('" + userData.LifeGroup + "')").prop('selected', true);
	$("input[name='checkOptEmail']").attr("checked", userData.OptEmail);
	$("input[name='checkOptTexts']").attr("checked", userData.OptText);
}

// Function for when editing a member is finished
function finishEditMember(userData)
{
	// Validate form data
	formResponse = {
		FirstName: $("input[name='editFirstName']").val(),
		LastName: $("input[name='editLastName']").val(),
		Email: $("input[name='editEmail']").val(),
		Phone: $("input[name='editPhone']").val(),
		Status: $("select[name='editStatus']").val(),
		Major: $("input[name='editMajor']").val(),
		LifeGroup: $("select[name='editLifeGroup']").val(),
		OptEmail: $("input[name='checkOptEmail']").is(":checked"),
		OptTexts: $("input[name='checkOptTexts']").is(":checked"),
		Valid: true
	};

	// Clean up phone number
	formResponse.Phone = cleanUpPhone(formResponse.Phone);

	if (!validateEmail(formResponse.Email))
	{
		$("input[name='editEmail']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='editEmail']").removeClass('is-invalid');

	if (formResponse.FirstName === '')
	{
		$("input[name='editFirstName']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='editFirstName']").removeClass('is-invalid');

	if (formResponse.LastName === '')
	{
		$("input[name='editLastName']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='editLastName']").removeClass('is-invalid');

	if (!validatePhone(formResponse.Phone))
	{
		$("div[name='editPhone']").text("Invalid Phone");
		$("input[name='editPhone']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='editPhone']").removeClass('is-invalid');

	if (formResponse.Major === '')
	{
		$("input[name='editMajor']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='editMajor']").removeClass('is-invalid');

  if (formResponse.Valid)
	{
		// Check if we need to validate the phone number being a duplicate
		if (formResponse.Phone != userData.Phone)
		{
			// Perform ajax call to find out if the phone number entered already exists
			var request = {Phone: formResponse.Phone};
			$.ajax({
				url: 'phpAjax/checkDuplicatePhone.php',
				method: 'POST',
				data: request,
				dataType: 'json',
				error: function() {ajaxError();},
				success: function(data) {

					if (data.Exists)
					{
						$("input[name='editPhone']").addClass("is-invalid");
						$("div[name='editPhone']").text("Phone Number Already Taken");
					}

					// Phone number does not already exist in DB. Continue check in
					else
					{
						$("#editMember").collapse("hide");
						$(".is-invalid").removeClass('is-invalid');

						// Update userData object after validation
						userData.FirstName = formResponse.FirstName;
						userData.LastName = formResponse.LastName;
						userData.Email = formResponse.Email;
						userData.Phone = formResponse.Phone;
						userData.Status = formResponse.Status;
						userData.Major = formResponse.Major;
						userData.LifeGroup = formResponse.LifeGroup;
						userData.OptEmail = formResponse.OptEmail;
						userData.OptText = formResponse.OptText;

						continueForm(userData);
					}
				}
			});
		}

		else
		{

			$("#editMember").collapse("hide");
			$(".is-invalid").removeClass('is-invalid');

			// Update userData object after validation
			userData.FirstName = formResponse.FirstName;
			userData.LastName = formResponse.LastName;
			userData.Email = formResponse.Email;
			userData.Phone = formResponse.Phone;
			userData.Status = formResponse.Status;
			userData.Major = formResponse.Major;
			userData.LifeGroup = formResponse.LifeGroup;
			userData.OptEmail = formResponse.OptEmail;
			userData.OptText = formResponse.OptText;

			continueForm(userData);
		}
	}
}

// Function for registering a new member. Gets called upon clicking the register button
// in registration form. Formats the data, creates a userData object. Calls continueForm when done
// and follows the path of a normal check in upon registration
function finishRegForm()
{
	// Get all of the data from the registration form
	formResponse = {
			FirstName: $("input[name='regFirst']").val(),
			LastName: $("input[name='regLast']").val(),
			Email: $("input[name='regEmail']").val(),
			Phone: $("input[name='regPhone']").val(),
			Status: $("select[name='regStatus']").val(),
			Major: $("input[name='regMajor']").val(),
			LifeGroup: "None",
			OptEmail: $("input[name='regOptEmail']").is(':checked'),
			OptTexts: $("input[name='regOptTexts']").is(':checked'),
			Valid: true
	};

	// Validate input
	// Clean up phone number
	formResponse.Phone = cleanUpPhone(formResponse.Phone);

	if (!validateEmail(formResponse.Email))
	{
		$("input[name='regEmail']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='regEmail']").removeClass('is-invalid');

	if (formResponse.FirstName === '')
	{
		$("input[name='regFirst']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='regFirst']").removeClass('is-invalid');

	if (formResponse.LastName === '')
	{
		$("input[name='regLast']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='regLast']").removeClass('is-invalid');

	if (!validatePhone(formResponse.Phone))
	{
		$("div[name='regPhone']").text("Invalid Phone");
		$("input[name='regPhone']").addClass('is-invalid');
		formResponse.Valid = false;
	}

	else
	{
		$("input[name='regPhone']").removeClass('is-invalid');

	}

	if (formResponse.Major === '')
	{
		$("input[name='regMajor']").addClass('is-invalid');
		formResponse.Valid = false;
	}
	else $("input[name='regMajor']").removeClass('is-invalid');

	if (formResponse.Valid)
	{
		// Need to check if phone number is already taken
		var request = {Phone: formResponse.Phone};
		$.ajax({
			url: 'phpAjax/checkDuplicatePhone.php',
			method: 'POST',
			data: request,
			dataType: 'json',
			error: function() {ajaxError();},
			success: function(data) {
				if(data.Exists)
				{
					$("input[name='regPhone']").addClass('is-invalid');
					$("div[name='regPhone']").text("Phone Number Already Taken");
				}

				// Form validated. Move on with check in
				else
				{
					$(".is-invalid").removeClass('is-invalid');

					userData = {
						FirstName: formResponse.FirstName,
						LastName: formResponse.LastName,
						Email: formResponse.Email,
						Phone: formResponse.Phone,
						Status: formResponse.Status,
						Major: formResponse.Major,
						LifeGroup: "None",
						OptEmail: formResponse.OptEmail,
						OptTexts: formResponse.OptTexts,
						PrayerRequest: ""
					};

					// Hide registration
					$("#registerModal").collapse("hide");

					continueForm(userData);
				}
			}
		});
	}
}

$(document).ready(function() {

	var userData = false;

	$(".editToggle").on("click", function() {

		// Disable all other inputs
		$(".inputToggle:not(." + this.id + ")").prop("disabled", true);

		// Toggle current input
		$("." + this.id).prop("disabled", function(index, cur_val) {
			return (cur_val) ? false : true;
		});

	});

	$("#checkIn").on("click", function() {

		// Perform ajax call to get user data
		phone = cleanUpPhone( $("#phone").val());
		var request = {Phone: phone};
		$.ajax ({
			url: 'phpAjax/getMemberData.php',
			method: 'POST',
			data: request,
			dataType: 'json',
			error: function() {ajaxError();},
			success: function(data) {

				userData = data;
				// If there is a user
				if (data.Exists)
				{
					$("input[name='phone']").removeClass("is-invalid");
					$("#registerModal").collapse("hide");

					// NOTE *************
					// Temporary code. Remove when data base is done
					userData = {
						FirstName: "Peyton",
						LastName: "Mathis",
						Email: "peymathi@iu.edu",
						Phone: "3174604323",
						Status: "Junior",
						Major: "Computer Science",
						LifeGroup: "None",
						OptEmail: true,
						OptText: true,
						PrayerRequest: ""
					};

					checkIn(userData);
					$("#checkInModal").modal("show");
				}
				else  $("input[name='phone']").addClass("is-invalid");
			}
		});

	});

	$("button[name='register']").on("click", finishRegForm);

	$("#register").on("click", function() {
		$("#displayData").collapse("hide");
		$("#modal-title").text("Welcome to CSF Night of Worship!");
		$("#registerModal").collapse("show");
		$("#checkInModal").modal("show");
	});

	$("#confirmInfo").on("click", function() {
		continueForm(userData);
	});

	$("#finishPrayer").on("click", function() {
		finishForm(userData);
	});

	$("#editMemberBtn").on("click", function() {
		editMember(userData);
	});

	$("#signUp").on("click", function () {
		displayLifegroups(userData);
	});

	$("#noThanks").on("click", function () {
		finishLifeGroups(userData);
	});

	$("#signUpConfirm").on("click", function () {
		finishLifeGroups(userData);
	});

	$("#decline").on("click", function() {
		finishLifeGroups(userData);
	});

	$("#saveEditMember").on("click", function() {
		finishEditMember(userData);
	});

	$("#cancelEditMember").on("click", function() {
		continueForm(userData);
	});

	// Hide all modal body divs on modal close
	$("#checkInModal").on("hidden.bs.modal", function(){
		$("#prayerRequest").collapse("hide");
		$("#askLifeGroups").collapse("hide");
		$("#finishForm").collapse("hide");
		$("#showLifeGroups").collapse("hide");
		$("#confirmLifeGroup").collapse("hide");
		$("#editMember").collapse("hide");
		$("#registerModal").collapse("show");
		$("#displayData").collapse("show");
	});

});
