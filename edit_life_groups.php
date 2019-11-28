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
	
	<div class="row">
		<div class="col">
		<form action="" method="post" class="needs-validation" novalidate>
			  <div class="form-group">
				<label for="life_group_name">Delete Life Group:</label>
				<select name="life_group_id" class="custom-select">						
					<?php
						echo '<option value="">None</option>';
						$LifeGroupIDStmt = $con->prepare("SELECT * FROM life_groups");
						$LifeGroupIDStmt->execute(array());
						while($LifeGroupRow = $LifeGroupIDStmt->fetch(PDO::FETCH_ASSOC)) {
							$isSelected = "";
							if($LifeGroupRow['LifeGroupID'] == $LifeGroupID){
								$isSelected = "selected";
							}
							echo "<option value=".$LifeGroupRow['LifeGroupID']." $isSelected>".$LifeGroupRow['LifeGroupName']."</option>";
						}
					?>
					</select>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Please fill out this field.</div>
				<span class="help-block"><?php echo $LifeGroupNameError; ?></span>
			  </div>
				<button type="submit" class="btn btn-danger">Delete</button>
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<a href="dashboard.php">
				<button type="submit" class="btn btn-secondary">Back</button>
			</a>
		</div>
	</div>
</div>

<script src="js/edit_life_groups.js"></script>
</body>
</html>
