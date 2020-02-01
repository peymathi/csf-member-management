<?php
include 'header.php';
session_verify();


require_once "phpUtil/db_connect.php";
require_once "checkinUserClass.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["deletemember"])){
		$deleteid = trim($_POST["deletemember"]);
		$MemberStmt = $con->prepare("DELETE FROM members WHERE `MemberID` = :MemberID");
		$MemberStmt->execute(array('MemberID' => $deleteid));

	}else{
		if(isset($_POST["editmember"])){
			$editid =  trim($_POST["editmember"]);
			$member;

			$MemberStmt = $con->prepare("SELECT * FROM members WHERE `MemberID` = :MemberID");
			$MemberStmt->execute(array('MemberID' => $editid));
			while($MemberRow = $MemberStmt->fetch(PDO::FETCH_ASSOC)) {
				$MemberID = $MemberRow['MemberID'];
				$FirstName = $MemberRow['FirstName'];
				$LastName = $MemberRow['LastName'];
				$EmailAddress = $MemberRow['EmailAddress'];
				$HomeAddress = $MemberRow['HomeAddress'];
				$PhoneNumber = $MemberRow['PhoneNumber'];
				$PhotoPath = $MemberRow['PhotoPath'];
				$PrayerRequest = $MemberRow['PrayerRequest'];
				$major = $MemberRow['Major'];
				$OptEmail = $MemberRow['OptEmail'];
				$OptText = $MemberRow['OptText'];
				$GroupID = $MemberRow['GroupID'];
				$LifeGroupID = $MemberRow['LifeGroupID'];
				$tempmemberobj =  new UserCheckin($MemberID, $FirstName, $LastName, $EmailAddress, $HomeAddress, $PhoneNumber, $PhotoPath, $PrayerRequest, $OptEmail, $OptText, $GroupID, $LifeGroupID);
				$member = $tempmemberobj;
			}
			$_SESSION["UserCheckin"] = $member;
			Header("location: edit_member.php");
		}
	}
}
?>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>
	<?php
		include 'headerMembers.php';
	?>
<div class="container" style="margin-top:30px">

	<div class="row">
		<div class="col">
			<table id="example" class="dataTable display" style="width:100%">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Home Address</th>
						<th>Phone Number</th>
						<th>Prayer Request</th>
						<th>Major</th>
						<th>Status</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php
							//loop through members
							$MembersStmt = $con->query("SELECT * FROM members");
							while($MembersRow = $MembersStmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<tr>";

								echo "<td>" . $MembersRow['FirstName'] . "</td>";
								echo "<td>" . $MembersRow['LastName'] . "</td>";
								echo "<td>" . $MembersRow['EmailAddress'] . "</td>";
								echo "<td>" . $MembersRow['HomeAddress'] . "</td>";
								echo "<td>" . $MembersRow['PhoneNumber'] . "</td>";
								echo "<td>" . $MembersRow['PrayerRequest'] . "</td>";
								echo "<td>" . $MembersRow['Major'] . "</td>";

								echo "<td>" ;
								$GroupStmt = $con->prepare("SELECT GroupName FROM groups WHERE GroupID = :GroupID");
								$GroupStmt->execute(array('GroupID' => $MembersRow['GroupID']));
								while($Group1Row = $GroupStmt->fetch(PDO::FETCH_ASSOC)) {
									echo $Group1Row['GroupName'];
								}
								echo "</td>";


								echo '<td>
								<form action="" method="post">
								<input type="hidden" id="editmember" name="editmember" value="'. $MembersRow['MemberID'] . '">
								<button type="submit" class="btn btn-secondary">Edit</button>

								</form>
								</td>';

								echo '<td>
								<form action="" method="post">
								<input type="hidden" id="deletemember" name="deletemember" value="'. $MembersRow['MemberID'] . '">
								<button type="submit" class="btn btn-danger">Delete</button>

								</form>
								</td>';

								echo "</tr>";
							}
					?>
				</tbody>
			</table>
		</div>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="export" value="CSV Export">Download to .csv</button>
		</form>
	</div>
</div>

<script src="js/member_management.js"></script>
</body>
</html>
<?php

//export data to csv
if(ISSET($_POST["export"])){
	ob_end_clean();

	$header="";
	$data="";

	$table ="members";
	$select = "SELECT * FROM members";
	$colNames = "DESCRIBE members";
	$q = $con->query($colNames);
	$q->execute();
	$export = $con->prepare( $select ) or die ( "Sql error : " . mysql_error( ) );
	$export->execute();
	$fields = $export->columnCount();
	for ( $i = 0; $i < $fields; $i++ ){
		$header .= $q->fetch(PDO::FETCH_COLUMN) . ",";
	}
	while( $row = $export->fetch(PDO::FETCH_OBJ)){
		$line = '';
		foreach( $row as $value ){
			if((!isset($value)) || ($value == "")){
				$value = ",";
			}else{
				$value = str_replace('"','""', $value);
				$value = '"'.$value.'"'.",";
			}
			$line .= $value;
		}
		$data .= trim( $line ) . "\n";
	}
	$data = str_replace("\r","",$data);
	if($data == ""){
		$data = "\n(0) Records Found!\n";
	}
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=members.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
}
?>
