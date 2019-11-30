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

	// TODO ****************
	// Get lifegroups from ajax call

	// TODO ****************
	// Add lifegroups to select element

	$("#showLifeGroups").collapse("show");
}

// Receives the lifegroups form
function finishLifeGroups(userData)
{
	// TODO ****************
	// Receive user data

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

	// TODO ************
	// Make ajax call to push new user data to DB
	if (userData.NewMember)
	{

	}

	// TODO ******************
	// Send the user's updated data to the DB through ajax call
	else
	{

	}

	// Delay for 5 seconds and then link back to original check in page
	setTimeout(function(){
		location.reload();
	}, 5000);
}

// Function that runs when a user wants to edit info
function editMember(userData)
{
	$("#displayData").collapse("hide");
	$("#editMember").collapse("show");

	// TODO ***************
	// Get the list of lifegroups through ajax call

	// Fill out form elements with user info
	$("input[name='editFirstName']").val(userData.FirstName);
	$("input[name='editLastName']").val(userData.LastName);
	$("input[name='editEmail']").val(userData.Email);
	$("input[name='editPhone']").val(userData.Phone);
	$("select[name='editStatus']").val(userData.Status);
	$("input[name='editMajor']").val(userData.Major);

	// TODO ***************
	// Populate life groups select element with options for each
	// life group.

	$("input[name='checkOptEmail']").attr("checked", userData.OptEmail);
	$("input[name='checkOptTexts']").attr("checked", userData.OptText);
}

// Function for when editing a member is finished
function finishEditMember(userData)
{
	$("#editMember").collapse("hide");

	// TODO ************
	// Validate form data

	// TODO************
	// Perform ajax call to push changes to member to DB

	continueForm(userData);
}

// Function for registering a new member. Gets called upon clicking the register button
// in registration form. Formats the data, creates a userData object. Calls continueForm when done
// and follows the path of a normal check in upon registration
function finishRegForm()
{
	// Get all of the data from the registration form
	// Create a new user object

	// TODO *********
	// Validate input

	userData = {
			FirstName: $("input[name='regFirst']").val(),
			LastName: $("input[name='regLast']").val(),
			Email: $("input[name='regEmail']").val(),
			Phone: $("input[name='regPhone']").val(),
			Status: $("select[name='regStatus']").val(),
			Major: $("input[name='regMajor']").val(),
			LifeGroup: "None",
			OptEmail: $("input[name='regOptEmail']").is(':checked'),
			OptTexts: $("input[name='regOptTexts']").is(':checked'),
			NewMember: true,
			PrayerRequest: ""
	};

	console.log(userData.FirstName);
	console.log(userData.LastName);
	console.log(userData.Email);
	console.log(userData.Phone);
	console.log(userData.Status);
	console.log(userData.Major);
	console.log(userData.LifeGroup);
	console.log(userData.OptEmail);
	console.log(userData.OptTexts);

	// Hide registration
	$("#registerModal").collapse("hide");

	continueForm(userData);
}

// Function that runs when a user enters a phone number. Attempts to get
// the user's data through an ajax call. Returns users data in an object
// with field names as attributes
function getMember(phone)
{
	// TODO************
	// Perform ajax call to get user data

	// If there is data, create an object and return it
	if(true)
	{
		return {
			FirstName: "Peyton",
			LastName: "Mathis",
			Email: "peymathi@iu.edu",
			Phone: "3174604323",
			Status: "Junior",
			Major: "Computer Science",
			LifeGroup: "Tuesday 6:00",
			OptEmail: true,
			OptText: true,
			NewMember: false,
			PrayerRequest: ""
		};
	}

	return false;
}

// Function that runs when an incorrect number was entered
function wrongNumber()
{
	$(".form-text").removeClass("d-none");
	$("#phone").val("");
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
		userData = getMember($("#phone").val());

		// If there is a user
		if (userData)
		{
			$("#registerModal").collapse("hide");
			checkIn(userData);
			$("#checkInModal").modal("show");
		}

		// If there is not a user
		else
		{
			wrongNumber();
		}

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
