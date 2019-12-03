<?php
include 'header.php';
session_verify();

require_once "phpUtil/db_connect.php";
require_once "lifeGroupClass.php";


if(isset($_POST['add'])) {
	$lifeGroupName = trim($_POST['lifeGroupName']);
	$lifeGroupDay = trim($_POST['lifeGroupDay']);
	//$lifeGroupTime = trim($_POST['lifeGroupTime']);
	$lifeGroupLocation = trim($_POST['lifeGroupLocation']);
	if($lifeGroupName != ""){
		$stmt = $con->prepare('INSERT INTO life_groups (LifeGroupID, LifeGroupName, LifeGroupDay, LifeGroupTime, LifeGroupLocation, LifeGroupActive)
		VALUES (Null, :lifeGroupName, :lifeGroupDay, "09:10:00", :lifeGroupLocation,"1")');
		$stmt->execute(array('lifeGroupName' => $lifeGroupName, 'lifeGroupDay' => $lifeGroupDay, 'lifeGroupLocation' => $lifeGroupLocation));
	}
}

if(isset($_POST['activate'])) {
	$lifeGroupNum = $_POST['lifeGroupNum'];
	$stmt = $con->prepare('UPDATE life_groups SET LifeGroupActive = 1 WHERE LifeGroupID = :LifeGroupID');
	$stmt->execute(array('LifeGroupID' => $lifeGroupNum));
}

if(isset($_POST['deactivate'])) {
	$lifeGroupNum = $_POST['lifeGroupNum'];
	$stmt = $con->prepare('UPDATE life_groups SET LifeGroupActive = 0 WHERE LifeGroupID = :LifeGroupID');
	$stmt->execute(array('LifeGroupID' => $lifeGroupNum));
}

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
	
		<div class="row mt-3">
			<div class="col-sm-6 col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<!-- PRINT ALL Life Groups-->
				<h4>List of active Life Groups are:</h4>
				<?php 
				$LifeGroupActiveStmt = $con->query("SELECT * FROM life_groups WHERE LifeGroupActive = 1");
				while($LifeGroupActiveRow = $LifeGroupActiveStmt->fetch(PDO::FETCH_ASSOC)) {
					echo $LifeGroupActiveRow["LifeGroupName"] . "</br>";
				} 
				?>
				</br></br>
				<h4>List of inactive Life Groups are:</h4>
				<?php 
				$LifeGroupInactiveStmt = $con->query("SELECT * FROM life_groups WHERE LifeGroupActive = 0");
				while($LifeGroupInactiveRow = $LifeGroupInactiveStmt->fetch(PDO::FETCH_ASSOC)) {
					echo $LifeGroupInactiveRow["LifeGroupName"] . "</br>";
				} 
				?>
			</div>
			<div class="col-sm-6 col-md-8">
				<!-- Add a Life Group-->
				<div class="row">
				
					<form action="" method="post">
					<div class="col-sm-12">
						<h4>Add Life Group</h4>
						<div class="input-group mb-3">
							Life Group Name:
							<input type="text" class="form-control" name="lifeGroupName">
							Life Group Day:
							<select name="lifeGroupDay">
								<option value="Sunday">Sunday</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
							</select>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input-group mb-3">
							Life Group Time:
							<input type="text" class="form-control" name="lifeGroupTime">
							Life Group Location:
							<input type="text" class="form-control" name="lifeGroupLocation">
							<div class="input-group-append">
								<button type="submit" class="btn btn-success" name="add">Add Life Group</button>
							</div>
						</div>
					</div>
					</form>
				</div>
				
				<!-- Edit a Life Group-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Edit Life Group</h4>
						<form action="" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="lifeGroupNameEdit">Life Groups</label>
								</div>
								<select class="custom-select" name="lifeGroupNum">
									<?php
									$LifeGroup1Stmt = $con->query("SELECT * FROM life_groups ORDER BY LifeGroupName ASC");
									while($row1 = $LifeGroup1Stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['LifeGroupID']."'>".$row1['LifeGroupName']."</option>";
									}
									?>
								</select>
								<input type="text" class="form-control" name="editLifeGroup">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary" name="edit">Edit Life Group</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- Reactivate a Life Group-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Reactivate Life Group</h4>
						<form action="" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="lifeGroupRemove">Inactive Life Groups</label>
								</div>
								<select class="custom-select" name="lifeGroupNum">
									<?php
									$LifeGroup2Stmt = $con->query("SELECT * FROM life_groups WHERE LifeGroupActive = 0 ORDER BY LifeGroupName ASC");
									while($row2 = $LifeGroup2Stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row2['LifeGroupID']."'>".$row2['LifeGroupName']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="activate">Activate Life Group</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<!-- Deactivate a Life Group-->
				<div class="row mt-2">
					<div class="col-sm-12">
						<h4>Deactivate Life Group</h4>
						<form action="" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="lifeGroupNameRemove"> Active Life Groups</label>
								</div>
								<select class="custom-select" name="lifeGroupNum">
									<?php
									$LifeGroup3Stmt = $con->query("SELECT * FROM life_groups WHERE LifeGroupActive = 1 ORDER BY LifeGroupName ASC");
									while($row3 = $LifeGroup3Stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row3['LifeGroupID']."'>".$row3['LifeGroupName']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-danger" name="deactivate">Deactivate Life Group</button>
								</div>
							</div>
						</form>
					</div>
				</div>			
			</div>
		</div>
	
	</div>


<script src="js/edit_life_groups.js"></script>
<!--<script src="js/edit_life_groups.js"></script>-->
</body>
</html>
