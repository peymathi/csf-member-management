<?php
    include 'header.php';
    session_verify();

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="checkin.php">Student Check In</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="member_management.php">Member Management</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="edit_life_groups.php">Life Group Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Reports</a>
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

		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td>John</td>
				<td>Doe</td>
				<td>john@example.com</td>
			  </tr>
			  <tr>
				<td>Mary</td>
				<td>Moe</td>
				<td>mary@example.com</td>
			  </tr>
			  <tr>
				<td>July</td>
				<td>Dooley</td>
				<td>july@example.com</td>
			  </tr>
			</tbody>
		  </table>


     </div>
  </div>
</div>

</body>
</html>
