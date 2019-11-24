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
	$("#modal-title").text("Welcome Back " + userData.Name + "!");

	// Display user's data
	$("#name").text("Name: " + userData.Name);
	$("#email").text("Email: " + userData.Email);
	$("#phoneNumber").text("Phone: " + userData.Phone);
	$("#status").text("Status: " + userData.Status);
	$("#major").text("Major: " + userData.Major);
	$("#life-groups").text("Life Group: " + userData.LifeGroup);
	$("#optEmail").text("Opt Into Emails: " + (userData.OptEmail ? "Yes" : "No"));
	$("#optText").text("Opt Into Texts: " + (userData.OptText ? "Yes" : "No"));
}

// Runs after user verifies their info.
function continueForm(userData)
{
	// Hide the old page
	$("#displayData").collapse("hide");

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

	// Add lifegroups to select element

	$("#showLifeGroups").collapse("show");
}

// Receives the lifegroups form
function finishLifeGroups(userData)
{
	// TODO ****************
	// Receive user data

	// Send data to DB with ajax call

	// Close the lifegroups divs

	// Open prayer request div
}

// Runs once the user has finished checking in
function finishForm(userData)
{
	$("#prayerRequest").collapse("hide");
	$("#finishForm").collapse("show");
	// TODO ******************
	// Send the user's data to the DB through ajax call

	// Delay for 5 seconds and then link back to original check in page
}

// Function that runs when a user wants to edit info
function editMember(userData)
{

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
			Name: "Peyton",
			Email: "peymathi@iu.edu",
			Phone: "3174604323",
			Status: "Junior",
			Major: "Computer Science",
			LifeGroup: "Tuesday, 6:00 Taylor Hall",
			OptEmail: true,
			OptText: true
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

	$("#checkIn").on("click", function() {
		userData = getMember($("#phone").val());

		// If there is a user
		if (userData)
		{
			$("#checkInModal").modal("show");
			checkIn(userData);
		}

		// If there is not a user
		else
		{
			wrongNumber();
		}

	});

	$("#confirmInfo").on("click", function() {
		continueForm(userData);
	});

	$("#finishPrayer").on("click", function() {
		finishForm(userData);
	});

	$("#editMember").on("click", function() {
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

	// Hide all modal body divs on modal close
	$("#checkInModal").on("hidden.bs.modal", function(){
		$("#displayData").collapse("hide");
		$("#prayerRequest").collapse("hide");
		$("#askLifeGroups").collapse("hide");
		$("#finishForm").collapse("hide");
		$("#showLifeGroups").collapse("hide");
		$("#confirmLifeGroup").collapse("hide");
	});

});
