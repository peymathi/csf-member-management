<?php
    include '../phpInc/header.php';
    session_verify();
	require_once '../phpUtil/db_connect.php';

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="../../img/logo.png" class="img-fluid" alt="Responsive image" width="700px" height="394px">
  <h1>Prayer Requests</h1>
</div>
<?php
	include '../phpInc/headerReports.php';
?>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">

		<h3>Prayer Requests</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Full Name</th>
				<th>Prayer</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$prayerStmt = $con->prepare("Select FirstName, LastName, PrayerRequest From Members");
				$prayerStmt->execute();
				while($prayerRow = $prayerStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$prayerRow['FirstName']." ".$prayerRow['LastName'].'</td><td>'.$prayerRow['PrayerRequest'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="exportPrayer" value="CSV Export">Download to .csv</button>
		</form>


     </div>
  </div>
</div>

</body>
</html>
