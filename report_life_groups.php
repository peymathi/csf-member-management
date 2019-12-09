<?php
    include 'header.php';
    session_verify();

	require_once 'phpUtil/db_connect.php';

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="img/logo.png" class="img-fluid" alt="Responsive image" width='200px' height='200px'>
  <h1>Life Groups Report</h1>
</div>
<?php
	include 'headerReports.php';
?>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
		<!-- Life Groups: Select FirstName, LastName, LifeGroup From Members Where Member is currently in a lifegroup -->
		<h3>Life Groups Members</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Life Group</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$lifeGroupStmt = $con->prepare("Select FirstName, LastName, LifeGroupID From Members Where LifeGroupID IS NOT NULL");
				$lifeGroupStmt->execute();
				while($lifeGroupRow = $lifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$lifeGroupRow['FirstName'].'</td><td>'.$lifeGroupRow['LastName'].'</td><td>'.$lifeGroupRow['LifeGroupID'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="exportInGroup" value="CSV Export">Download to .csv</button>
		</form>
		<!-- People Not In Lifegroup: Select FirstName, LastName, Email, PhoneNumber From Members Where Member is not currently in a lifegroup -->
		<h3>People Not In Life Group</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email Address</th>
				<th>Phone Number</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$lifeGroup2Stmt = $con->prepare("Select FirstName, LastName, EmailAddress, PhoneNumber From Members Where LifeGroupID = NULL");
				$lifeGroup2Stmt->execute();
				while($lifeGroup1Row = $lifeGroup2Stmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$lifeGroup1Row['FirstName'].'</td><td>'.$lifeGroup1Row['LastName'].'</td><td>'.$lifeGroup1Row['EmailAddress'].'</td><td>'.$lifeGroup1Row['PhoneNumber'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="exportNoGroup" value="CSV Export">Download to .csv</button>
		</form>
     </div>
  </div>
</div>

</body>
</html>
