<?php
include 'header.php';
session_verify();

require_once "db_connect.php";
require_once "lifeGroupClass.php";

$LifeGroupNameError = "";

$lifegroups = [];

$LifeGroupStmt = $con->prepare("SELECT * FROM life_groups");
$LifeGroupStmt->execute(array());
while($GroupRow = $LifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
	$lifegroupid = $GroupRow['LifeGroupID'];
	$lifegroupname = $GroupRow['LifeGroupName'];
	$members = [];
	
	$MembersStmt = $con->prepare("SELECT * FROM members WHERE LifeGroupID = :LifeGroupID");
	$MembersStmt->execute(array(':LifeGroupID' => $lifegroupid));
	while($MemberRow = $MembersStmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($members, ( $MemberRow['FirstName'] . " " . $MemberRow['LastName'] ) );
	}
	$templifegroupobj =  new LifeGroup($lifegroupid, $lifegroupname, $members);
	array_push($lifegroups, $templifegroupobj);
}

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>

<div class="container" style="margin-top:30px">

	<div class="row">
		<div class="col">
			<table id="example" class="display nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Life Group Name</th>
						<th>Members</th>
					</tr>
				</thead>
				<tbody>
					<?php
							//loop through life groups
							foreach($lifegroups as $group) {
								echo "<tr>";
								
								echo "<td>" . $group->getLifeGroupName() . "</td>";
								
								$memberString = "";
								foreach($group->getMembers() as $member) {
									$memberString .= " " . $member;
								}
								echo "<td>" . $memberString . "</td>";

								echo '</td>';
								
								echo "</tr>";
							}
					?>
				</tbody>
			</table>

		</div>
	</div>
	
	<div class="row">
		<div class="col">
		<form action="" method="post" class="needs-validation" novalidate>
			  
			  <div class="form-group">
				<label for="life_group_name">Add Life Group:</label>
				<input type="text" class="form-control" id="life_group_name" placeholder="Enter life group name" name="life_group_name" required>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $LifeGroupNameError; ?></span>
			  </div>
			  
			  <button type="submit" class="btn btn-primary">Add Group</button>
			</form>
		</div>
	</div>

	<div class="row mt-2">
		<div class="col">
			<a href="life_group_dashboard.php">
				<button type="submit" class="btn btn-secondary">Back</button>
			</a>
		</div>
	</div>
</div>


<script src="js/edit_life_groups.js"></script>
<!--<script src="js/add_life_group.js"></script> -->
</body>
</html>
