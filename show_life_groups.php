<?php
include 'header.php';
session_verify();


require_once "db_connect.php";
require_once "lifeGroupClass.php";


$LifeGroupName = "";
$LifeGroupNameError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["deletelifegroup"])){
		$deleteid = trim($_POST["deletelifegroup"]);
		$LifeGroupStmt = $con->prepare("DELETE FROM life_groups WHERE `LifeGroupID` = :LifeGroupID");
		$LifeGroupStmt->execute(array('LifeGroupID' => $deleteid));

	}else{

		if(empty(trim($_POST["life_group_name"]))){
			$LifeGroupNameError = "Must enter name.";
		} else {
			$LifeGroupName = trim($_POST["life_group_name"]);
		}

		if(
		!empty($LifeGroupNameError)
		){
			$any_error = "errors";
			
		}

		if(empty($any_error)){
		
			$updateStmt = $con->prepare('INSERT INTO life_groups (`LifeGroupName`) VALUES
			(:LifeGroupName)');
			$updateStmt->execute(array('LifeGroupName' => $LifeGroupName));
		}

	}

}

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
	
	<div class="row mt-2">
		<div class="col">
			<a href="life_group_dashboard.php">
				<button type="submit" class="btn btn-secondary">Back</button>
			</a>
		</div>
	</div>
</div>

<script src="js/edit_life_groups.js"></script>
</body>
</html>
