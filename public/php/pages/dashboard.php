<?php
    include '../phpInc/header.php';
    session_verify();
	  require_once '../phpUtil/db_connect.php';
?>
<body>

<div class="jumbotron text-center" style="margin-bottom:0">
  <img src="../../img/logo.png" class="img-fluid" alt="Responsive image" width="700px" height="394px">
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="preCheckin.php">Night of Worship Check In</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="member_management.php">Member Management</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="life_group_dashboard.php">Life Group Management</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports_dashboard.php">Reports</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="change_password.php">Change password</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
</nav>

<div class="container" style="margin-top:30px">
  <div class="row">

    <div class="col">
      <table id="example" class="dataTable display" style="width:100%">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Prayer</th>
            <th>Group ID</th>
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

      <script type="text/javascript">
        $(document).ready(function(){
           $('.dataTable').DataTable({
             responsive:true
           });
        });
      </script>

     </div>
  </div>
</div>

</body>
</html>
