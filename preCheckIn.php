<?php
  // Page that creates a new night of worship and begins checkin process
  include 'header.php';
  session_verify();
  require_once "phpUtil/db_connect.php";

  // Runs if the form has been submitted
  if(isset($_POST['submitBtn']))
  {
    $date = $_POST['nowdate'];

    // Check if night of worship with that date has already been made

    // Make a night of worship with that date

    Header("Location: checkin.php");
  }

?>

<body>
<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="img/logo.png" class="img-fluid" alt="Responsive image" width='200px' height='200px'>
  <h1>Night of Worship Check In</h1> <!--Add title to header.php as well for tab name-->
</div>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
  <ul class="navbar-nav">
    <li class='nav-item'>
      <a class="nav-link" href="dashboard.php">Go Back</a>
    </li>
  </ul>
</nav>

<div class="container" style="margin-top:30px">
    <form action='preCheckin.php' method='post' class='needs-validation'>
      <div class='form-group'>
        <label class='form-group' for='nowdate'>Select the date of the Night of Worship:</label>
        <input type='date' class='form-group input-medium bfh-date' name='nowdate' required>
        <div class='invalid-feedback'>Must select a date</div>
      </div>
      <button type='submit' class='btn btn-primary' name='submitBtn'>Begin Night of Worship</button>
    </form>
  </div>
</div>

</body>
</html>
