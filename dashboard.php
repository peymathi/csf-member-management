<?php
    include 'header.php';
    session_verify();

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="img/logo.png" class="img-fluid" alt="Responsive image" width='200px' height='200px'>
  <h1>Member Tracking Dashboard</h1>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="preCheckin.php">Night of Worship Check In</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="member_management.php">Member Management</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="life_group_dashboard.php">Life Group Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports_dashboard.php">Reports</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="change_password.php">Change password</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
</nav>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
     </div>
  </div>
</div>

</body>
</html>
