<!----- PHP SECTION ----->

<?php
session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

// Holds the userID

$tempUserID = $_SESSION['userID'];
?>



<!DOCTYPE HTML>

<title> Groups Overview </title>
<link rel = "stylesheet" href = "bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
<table class = "table">
		<thead>
			<tr>
				<th> Group Name </th>
				<th> Group Member's ID</th>
				<th> Group Member's Email</th>
				<th> Group Member's Phone Number</th>
				<th> Manager </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";

		// Query for initial Groups

		$sqlOne = "SELECT groupId FROM GroupsUsers WHERE employeeId = $tempUserID";

		$stmt = $conn->query($sqlOne);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{

		// Query for all groupmembers within a group and check for their

		$sqlTwo = "SELECT firstName, lastName, phoneNumber, email, employeeId FROM Employees FULL OUTER JOIN ON GroupsUsers.employeeId = Employees.employeeId WHERE GroupsUsers.groupId = $row[groupId]";

		}
		?>

	</tbody>
</table>





	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
</HTML>