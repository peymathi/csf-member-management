<?php
    include 'header.php';
    session_verify();
	require_once 'phpUtil/db_connect.php';
?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="img/logo.png" class="img-fluid" alt="Responsive image" width='200px' height='200px'>
  <h1>Contact Information</h1>
</div>
<?php
	include 'headerReports.php';
?>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
		<!-- Contact Emails: Select FirstName, LastName, Email From Members Where OptEmail = True
			}
		-->
		<h3>Opted in to Email</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$emailStmt = $con->prepare("Select FirstName, LastName, EmailAddress From Members Where OptEmail = 1");
				$emailStmt->execute();
				while($emailRow = $emailStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$emailRow['FirstName'].'</td><td>'.$emailRow['LastName'].'</td><td>'.$emailRow['EmailAddress'].'</td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		<!-- Contact Texts: Select FirstName, LastName, PhoneNumber From Members Where OptTexts = True -->
		<h3>Opted in to Text</h3>
		<table class="table">
			<thead class="thead-dark">
			  <tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Phone Number</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$emailStmt = $con->prepare("Select FirstName, LastName, PhoneNumber From Members Where OptText = 1");
				$emailStmt->execute();
				while($emailRow = $emailStmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<tr>';
					echo '<td>'.$emailRow['FirstName'].'</td><td>'.$emailRow['LastName'].'</td><td>'.$emailRow['PhoneNumber'].'</td>';
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
