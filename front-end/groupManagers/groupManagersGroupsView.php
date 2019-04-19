<!----- PHP SECTION ----->

<?php
session_start();
// If user isn't logged in then they will be redirected back to the log in page.
if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2)
{header ("Location: ../login.php");}
// Holds the userID
$tempUserID = $_SESSION['userID'];
$searchBool = false;

?>



<!DOCTYPE HTML>

<title> Groups Overview </title>
<link rel = "stylesheet" href = "../users/bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="groupManagersIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div>
	</div>

	<center>
	<form method = "post">
	<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="taskFind" placeholder="Search for Tasks">
 		<button type = "submit" name = "searchTask" class="btn btn-info">search</button> 
 	</div>
 	</form>
 	</center>


	<a href = 'actions/removeGroupMember.php'><button type = "button" name = "removeGroupMember" class = "btn btn-danger float-right btn-space"> Remove Group Member </button> </a>
	<a href = 'actions/addGroupMember.php'><button type="button" name = "addGroupMember" class="btn btn-success float-right btn-space">Add Group Member</button> </a>

<table class = "table">
		<thead>
			<tr>
				<th> Related to Project </th>
				<th> Group Member's Name </th>
				<th> Group Member's Email</th>
				<th> Group Member's Phone Number</th>
				<th> Role </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";
		// Creating Enumerated types via arrays again
		$roleIdArray = array("", "Employee", "Manager", "Project Manager");

		if (isset($_POST['searchTask']))
		{
			$searchBool = true;


			$searchGroupMember = $_POST['taskFind'];

			echo $searchGroupMember;

			$sqlOneV2 = "SELECT groupName, Groups.groupId FROM Groups INNER JOIN GroupsUsers ON Groups.groupId = GroupsUsers.groupId WHERE employeeId = $tempUserID";

			$stmtOne = $conn->query($sqlOneV2);

			while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
			{
				$sqlTwoV2 = "SELECT Employees.employeeId, firstName, lastName, email, phoneNumber, role FROM Employees INNER JOIN GroupsUsers ON Employees.employeeId = GroupsUsers.employeeId WHERE
				GroupsUsers.employeeId != $tempUserID AND GroupsUsers.groupId = $rowOne[groupId]";

				$stmtTwo = $conn->query($sqlTwoV2);

				while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
				{

					$sqlThreeV2 = "SELECT projectName FROM Projects INNER JOIN ProjectUsers ON Projects.projectId = ProjectUsers.projectId INNER JOIN GroupsUsers ON GroupsUsers.groupId = $rowOne[groupId] WHERE ProjectUsers.employeeId = $rowTwo[employeeId]";

					$stmtThree = $conn->query($sqlThreeV2);

					while ($rowThree = $stmtThree->fetch(PDO::FETCH_ASSOC))
					{
					echo "<tr><td>".$rowThree['projectName']."</td>
					<td>".$rowTwo['firstName']." ".$rowTwo['lastName']."</td>
					<td>".$rowTwo['email']."</td>
					<td>".$rowTwo['phoneNumber']."</td>
					<td>".$roleIdArray[$rowTwo['role']]."</td>
					</tr>";
					}

				}

			}

		}

		else if ($searchBool == false){
		// Query for initial Groups that the user is involved in
		$sqlOne = "SELECT groupId FROM GroupsUsers WHERE employeeId = $tempUserID";
		$stmt = $conn->query($sqlOne);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
		// Query for all employeeIds - given the groups that they're involved in
		$sqlTwo = "SELECT employeeId FROM GroupsUsers WHERE groupId = $row[groupId]";
		// Query for the information and output to the table
		$stmt2 = $conn->query($sqlTwo);
			// Query for all employee information given the employeeIds we queried from earlier
			while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
			{
				$sqlThree = "SELECT firstName, lastName, employeeId, email, phoneNumber, role FROM Employees WHERE Employees.employeeId = $row2[employeeId]";
				$stmt3 = $conn->query($sqlThree);
				while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
				{

				$sqlFour = "SELECT projectName FROM ProjectUsers INNER JOIN Projects ON employeeId = $row3[employeeId]";

				$stmt4 = $conn->query($sqlFour);

				$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

				// Print to the table
				echo "<tr><td>".$row4['projectName']."</td>
				<td>".$row3['firstName']." ".$row3['lastName']."</td>
				<td>".$row3['email']."</td>
				<td>".$row3['phoneNumber']."</td>
				<td>".$roleIdArray[$row3['role']]."</td>
				</tr>"
				;
				}
			}
		}
		}
		?>




	</tbody>
</table>





</body>
</HTML>