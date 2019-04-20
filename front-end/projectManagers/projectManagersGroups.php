<!----- PHP SECTION ----->

<?php
session_start();
// If user isn't logged in then they will be redirected back to the log in page.
if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
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
				<a href="projectManagersIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div>
	</div>


	<a href = 'actions/addGroupsProjectManagement.php'><button type="button" name = "addGroup" class="btn btn-success float-right btn-space">Assign New Group</button></a>
	<a href = 'actions/addGroupsMembersProjectManagement.php'><button type="button" name = "addGroupMember" class="btn btn-success float-right btn-space">Assign Group Member</button></a>

<table class = "table">
		<thead>
			<tr>
				<th> Belongs to Project </th>
				<th> Belongs to Group </th>
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

		// Query for projects that a project Manager is in charge of

		$sqlFindProjects = "SELECT projectId, projectName FROM Projects WHERE projectManagerID = $tempUserID";

		$stmtOne = $conn->query($sqlFindProjects);

		while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
		{
			$sqlFindGroupEmployees = "SELECT groupName, employeeId FROM Groups INNER JOIN GroupsUsers ON Groups.groupId = GroupsUsers.groupId WHERE Groups.projectId = $rowOne[projectId]";

			$stmtTwo = $conn->query($sqlFindGroupEmployees);

			while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
			{
				$sqlFindEmployeeInfo = "SELECT firstName, lastName, email, phoneNumber, role FROM Employees WHERE Employees.employeeId = $rowTwo[employeeId]";

				$stmtThree = $conn->query($sqlFindEmployeeInfo);
				while ($rowThree = $stmtThree->fetch(PDO::FETCH_ASSOC))
				{
				// Print to the table
				echo "<tr><td>". $rowOne['projectName'] ."</td>
				<td>".$rowTwo['groupName']."</td>
				<td>".$rowThree['firstName']." ".$rowThree['lastName']."</td>
				<td>".$rowThree['email']."</td>
				<td>".$rowThree['phoneNumber']."</td>
				<td>".$roleIdArray[$rowThree['role']]."</td>
				</tr>";
				}
			}
		}

		?>




	</tbody>
</table>





</body>
</HTML>