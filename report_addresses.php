<?php
    include 'header.php';
    session_verify();
	
	require_once 'phpUtil/db_connect.php';

?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
<?php
	include 'headerReports.php';
?>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
		<!-- Home Addresses: Select FirstName, LastName, HomeAddress From Members Where HomeAddress Not Null -->
		<h3>Home Address</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Home Address</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$homeStmt = $con->prepare("Select FirstName, LastName, HomeAddress From Members Where HomeAddress IS NOT NULL");
				$homeStmt->execute();
				while($homeRow = $homeStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$homeRow['FirstName'].'</td><td>'.$homeRow['LastName'].'</td><td>'.$homeRow['HomeAddress'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
  </div>
</div>

</body>
</html>
