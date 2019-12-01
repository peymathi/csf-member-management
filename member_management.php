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





$members = [];

$MembersStmt = $con->prepare("SELECT * FROM members");
$MembersStmt->execute(array());
while($GroupRow = $MembersStmt->fetch(PDO::FETCH_ASSOC)) {
	$MemberID = $GroupRow['MemberID'];
	$FirstName = $GroupRow['FirstName'];
	$LastName = $GroupRow['LastName'];
	$EmailAddress = $GroupRow['EmailAddress'];
	$HomeAddress = $GroupRow['HomeAddress'];
	$PhoneNumber = $GroupRow['PhoneNumber'];
	$PhotoPath = $GroupRow['PhotoPath'];
	$PrayerRequest = $GroupRow['PrayerRequest'];
	$OptEmail = $GroupRow['OptEmail'];
	$OptText = $GroupRow['OptText'];
	$GroupID = $GroupRow['GroupID'];
	$LifeGroupID = $GroupRow['LifeGroupID'];

	$GroupName = "";
	$LifeGroupName = "";

	$LifeGroupStmt = $con->prepare("SELECT * FROM life_groups WHERE `LifeGroupID` = :LifeGroupID");
	$LifeGroupStmt->execute(array("LifeGroupID"=>$LifeGroupID));
	while($LifeGroupRow = $LifeGroupStmt->fetch(PDO::FETCH_ASSOC)) {
		$LifeGroupName = $LifeGroupRow['LifeGroupName'];
	}

	$GroupStmt = $con->prepare("SELECT * FROM groups WHERE `GroupID` = :GroupID");
	$GroupStmt->execute(array("GroupID"=>$GroupID));
	while($GroupRow = $GroupStmt->fetch(PDO::FETCH_ASSOC)) {
		$GroupName = $GroupRow['GroupName'];
	}




	$tempmemberobj =  new UserCheckin($MemberID, $FirstName, $LastName, $EmailAddress, $HomeAddress, $PhoneNumber, $PhotoPath, $PrayerRequest, $OptEmail, $OptText, $GroupID, $LifeGroupID,$GroupName,$LifeGroupName);
	array_push($members, $tempmemberobj);
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
						<th>Edit</th>
						<th>Delete</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Address</th>
						<th>Phone Number</th>
						<th>Prayer</th>
						<th>OptEmail</th>
						<th>OptText</th>
						<th>Group</th>
						<th>Life Group</th>
					</tr>
				</thead>
				<tbody>
					<?php
							//loop through life groups
							foreach($members as $member) {
								echo "<tr>";

								echo '<td>
								<form action="" method="post">
								<input type="hidden" id="editmember" name="editmember" value="'. $member->getMemberID() . '">
								<button type="submit" class="btn btn-secondary">Edit</button>

								</form>
								</td>';

								echo '<td>
								<form action="" method="post">
								<input type="hidden" id="deletemember" name="deletemember" value="'. $member->getMemberID() . '">
								<button type="submit" class="btn btn-danger">Delete</button>

								</form>
								</td>';



								echo "<td>" . $member->getFirstName() . "</td>";
								echo "<td>" . $member->getLastName() . "</td>";
								echo "<td>" . $member->getEmailAddress() . "</td>";
								echo "<td>" . $member->getHomeAddress() . "</td>";
								echo "<td>" . $member->getPhoneNumber() . "</td>";
								echo "<td>" . $member->getPrayerRequest() . "</td>";

								if($member->getOptEmail() == "0"){
									echo "<td>No</td>";
								}else{
									echo "<td>Yes</td>";
								}

								if($member->getOptText() == "0"){
									echo "<td>No</td>";
								}else{
									echo "<td>Yes</td>";
								}

								echo "<td>" . $member->getGroupName() . "</td>";
								echo "<td>" . $member->getLifeGroupName() . "</td>";

								echo "</tr>";
							}
					?>
				</tbody>
			</table>
		</div>
		<form method = "post" action = "">
			<button type="submit" class="btn btn-primary" name="export" value="CSV Export">Download to .csv</button>
		</form>
		&nbsp;&nbsp;
		<a href="register.php">
		  <button type="submit" class="btn btn-primary">Add Member</button>
		</a>
		&nbsp;&nbsp;
		<a href="dashboard.php">
			<button type="submit" class="btn btn-secondary">Back</button>
		</a>
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
