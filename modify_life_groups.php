<?php
include 'header.php';
session_verify();

require_once "phpUtil/db_connect.php";
require_once "lifeGroupClass.php";

$LifeGroupNameActError = "";
$LifeGroupNameDelError = "";
$LifeGroupNameError = "";

$LifeGroupStmt = $con->query("SELECT * FROM life_groups");
$MembersStmt = $con->query("SELECT * FROM members WHERE LifeGroupID = :LifeGroupID");

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
				while($LifeGroupRow = $LifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
					echo $LifeGroupRow["LifeGroupName"] . "</br>";
				} ?>
				</br></br>
				<h4>List of inactive Life Groups are:</h4>
				<?php 
				while($LifeGroupRow = $LifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
					echo $LifeGroupRow["LifeGroupName"] . "</br>";
				} ?>
			</div>
			<div class="col-sm-6 col-md-8">
				<!-- Add a Life Group-->
				<div class="row">
					<div class="col-sm-12">
						<h4>Add Life Group</h4>
						<form action="" method="post">
							<div class="input-group mb-3">
								<input type="text" class="form-control" name="addLifeGroup">
								<div class="input-group-append">
									<button type="submit" class="btn btn-success" name="add">Add Life Group</button>
								</div>
							</div>
						</form>
					</div>
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
									$LifeGroup2Stmt = $con->query("SELECT * FROM life_groups ORDER BY LifeGroupName ASC");
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
									$LifeGroup3Stmt = $con->query("SELECT * FROM life_groups ORDER BY LifeGroupName ASC");
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
