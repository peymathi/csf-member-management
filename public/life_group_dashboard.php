<?php
include 'header.php';
session_verify();

require_once "phpUtil/db_connect.php";
require_once "lifeGroupClass.php";

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<body>
	<div class="jumbotron text-center" style="margin-bottom:0">
		<h1>Impact Member Tracking</h1>
	</div>
	<?php
		include 'headerLifeGroup.php';
	?>
	<div class="container" style="margin-top:30px">
	<div class="row">
		<div class="col">
			<table id="example" class="display nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Life Group Name</th>
						<th>Life Group Day</th>
						<th>Life Group Time</th>
						<th>Life Group Location</th>
						<th>Life Group Active</th>
						<th># of Members</th>
						<th>Members</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//loop through life groups
						$LifeGroupStmt = $con->query("SELECT * FROM life_groups");
						while($GroupRow = $LifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<tr>";
							echo "<td>" . $GroupRow["LifeGroupName"] . "</td>";
							
							echo "<td>" . $GroupRow["LifeGroupDay"]. "</td>";
							
							echo "<td>" . $GroupRow["LifeGroupTime"]. "</td>";
							
							echo "<td>" . $GroupRow["LifeGroupLocation"]. "</td>";
							
							echo "<td>" . $GroupRow["LifeGroupActive"]. "</td>";
							
							$memberString = "";
							$counter = 0;
							$MembersStmt = $con->prepare("SELECT * FROM members WHERE LifeGroupID = :LifeGroupID");
							$MembersStmt->execute(array('LifeGroupID' => $GroupRow["LifeGroupID"]));
							while($MemberRow = $MembersStmt->fetch(PDO::FETCH_ASSOC)) {
								$counter++;
								$memberString = $memberString + " " + $MemberRow['FirstName'] + " " + $MemberRow['LastName'];
							}
							
							echo "<td>" . $counter . "</td>";
							
							echo "<td>" . $memberString . "</td>";

							echo '</td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script src="js/edit_life_groups.js"></script>
<!--<script src="js/toggle_life_groups.js"></script>-->
</body>
</html>
