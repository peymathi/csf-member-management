<?php
include 'header.php';
session_verify();


require_once "db_connect.php";
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
	
	$tempmemberobj =  new UserCheckin($MemberID, $FirstName, $LastName, $EmailAddress, $HomeAddress, $PhoneNumber, $PhotoPath, $PrayerRequest, $OptEmail, $OptText, $GroupID, $LifeGroupID);
	array_push($members, $tempmemberobj);
}



?>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>

<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Impact Member Tracking</h1>
</div>

<div class="container" style="margin-top:30px">

	
		<div class="row mt-2">
			<div class="col">
				<a href="dashboard.php">
					<button type="submit" class="btn btn-secondary">Back</button>
				</a>
			</div>
		


	
		<div class="col">
			<a href="register.php">
			  <button type="submit" class="btn btn-primary">Add Member</button>
			</a>
		</div>
	</div>

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
								echo "<td>" . $member->getOptEmail() . "</td>";
								echo "<td>" . $member->getOptText() . "</td>";
								echo "<td>" . $member->getGroupID() . "</td>";
								echo "<td>" . $member->getLifeGroupID() . "</td>";

								


								
								echo "</tr>";
							}
					?>
				</tbody>
			</table>

		</div>
	</div>
</div>

<script src="member_management.js"></script>
</body>
</html>
