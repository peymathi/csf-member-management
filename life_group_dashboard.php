<?php
include 'header.php';
session_verify();

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<body>
	<div class="jumbotron text-center" style="margin-bottom:0">
		<h1>Impact Member Tracking</h1>
	</div>
	<div class="container" style="margin-top:30px">

		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Show Life Groups/Members</h5>
						<p class="card-text">All the Life Groups with a list of each members name in some order.</p>
						<a href="show_life_groups.php" class="btn btn-primary">Show</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add new Life Group</h5>
						<p class="card-text">Add a new Life Group for members to sign up for.</p>
						<a href="add_life_group.php" class="btn btn-warning">Add</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Toggle Life Group Active/Inactive</h5>
						<p class="card-text">Allows the Life Groups to be avaliable or hidden for the users.</p>
						<a href="toggle_life_groups.php" class="btn btn-danger">Toggle</a>
					</div>
				</div>
			</div>
		</div> <!-- end of row div -->
		<div class="row mt-2">
			<div class="col">
				<a href="dashboard.php">
					<button type="submit" class="btn btn-secondary">Back</button>
				</a>
			</div>
		</div>
	</div> <!-- end of container div -->
	

</body>
</html>