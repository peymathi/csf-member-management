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
function checkIn()
{
	// Get user's data with ajax call

	// Update modal header

	// Display user's data

	// Ask if the user would like to edit their data

}

// Runs after user verifies their info.
function continueForm()
{
	// Check if the user is not in a lifegroup

	// Update modal header

	// Ask the user for their prayer request

}

// Runs if the user is not in a lifegroup
function displayLifegroups()
{
	// Update modal header
}

// Receives the lifegroups form
function finishLifeGroups()
{
	// Receive user data

	// Send data to DB with ajax call
}

// Runs once the user has finished checking in
function finishForm()
{
	// Send the user's data to the DB through ajax call

	// Show the user the final screen

	// Delay for 5 seconds and then link back to original check in page

}

$(document).ready(function() {

	$("checkIn").on("click", checkIn);
	$("confirmInfo").on("click", continueForm);
	$("finishForm").on("click", finishForm);
	$("finishLifeGroups").on("click", finishLifeGroups);

});
