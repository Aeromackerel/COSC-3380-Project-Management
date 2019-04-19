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

<title> Project Overview </title>
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


<table class = "table">
		<thead>
			<tr>
				<th> Employee's Name </th>
				<th> Email</th>
				<th> Phone Number</th>
				<th> Role </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";
		// Creating Enumerated types via arrays again
		$roleIdArray = array("", "Basic Employee", "Manager", "Project Manager");
		// Query for initial Projects that the user is involved in
		$sqlOne = "SELECT projectId FROM ProjectUsers WHERE employeeId = $tempUserID";
		$stmt = $conn->query($sqlOne);
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
		// Query for all employeeIds - given the projects that they're involved in
		$sqlTwo = "SELECT DISTINCT employeeId FROM ProjectUsers WHERE projectId = $row[projectId]";
		// Query for the information and output to the table
		$stmt2 = $conn->query($sqlTwo);
			// Query for all employee information given the employeeIds we queried from earlier
			while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
			{
				$sqlThree = "SELECT firstName, lastName, employeeId, email, phoneNumber, role FROM Employees WHERE Employees.employeeId = $row2[employeeId]";
				$stmt3 = $conn->query($sqlThree);
				while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
				{
					// Print to the table
				echo "<tr><td>".$row3['firstName']." ".$row3['lastName']."</td>
				<td>".$row3['email']."</td>
				<td>".$row3['phoneNumber']."</td>
				<td>".$roleIdArray[$row3['role']]."</td>
				</tr>"
				;
				}
			}
		}
		?>




	</tbody>
</table>





</body>
</HTML>