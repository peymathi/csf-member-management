<?php
    include '../phpInc/header.php';
    session_verify();

	require_once '../phpUtil/db_connect.php';

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="../../img/logo.png" class="img-fluid" alt="Responsive image" width="400px" height="200px">
  <h1>Life Groups Report</h1>
</div>
<?php
	include '../phpInc/headerReports.php';
?>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
		<!-- Life Groups: Select FirstName, LastName, LifeGroup From Members Where Member is currently in a lifegroup -->
		<h3>Life Groups Members</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Name</th>
				<th>Life Group</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$lifeGroupStmt = $con->prepare("SELECT members.FirstName, members.LastName, life_groups.LifeGroupName FROM `member_life_group_junction`  INNER JOIN members ON members.MemberID = member_life_group_junction.MemberID INNER JOIN life_groups ON life_groups.LifeGroupID = member_life_group_junction.LifeGroupID");
				$lifeGroupStmt->execute();
				while($lifeGroupRow = $lifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$lifeGroupRow['FirstName']." ".$lifeGroupRow['LastName'].'</td><td>'.$lifeGroupRow['LifeGroupName'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="exportInGroup" value="CSV Export">Download to .csv</button>
		</form>
     </div>
  </div>
</div>

</body>
</html>
