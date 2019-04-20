<!----- PHP SECTION ----->

<?php
session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

// Holds the userID

$tempUserID = $_SESSION['userID'];

$searchBool = false;

?>



<!DOCTYPE HTML>

<title> Groups Overview </title>
<link rel = "stylesheet" href = "bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="userIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>

	<center>
	<form method = "post">
		<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="groupFind" placeholder="Search for Group">
 		<button type = "submit" name = "searchGroup" class="btn btn-info">search</button>
 	</div>
 	</form>
 </center>

<table class = "table">
		<thead>
			<tr>
				<th> Belongs to Group </th>
				<th> Belongs to Project </th>
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

		$searchBool = false;

		if (isset($_POST['searchGroup']))
			{$searchBool = true;}

		// Creating Enumerated types via arrays again

		$roleIdArray = array("", "", "Manager", "Project Manager");

		// Re-search for group

		if ($searchBool == true)
		{

		}

		// Query for initial Groups that the user is involved in

		if($searchBool == false){

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

				$searchGroup = "SELECT groupName FROM Groups WHERE groupId = $row[groupId]";

				$stmtGroupName = $conn->query($searchGroup);

				$rowFind = $stmtGroupName->fetch(PDO::FETCH_ASSOC);

				$groupName = $rowFind['groupName'];
			
				$sqlThree = "SELECT firstName, lastName, employeeId, email, phoneNumber, role FROM Employees WHERE Employees.employeeId = $row2[employeeId]";

				$stmt3 = $conn->query($sqlThree);

				while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
				{

				$sqlFour = "SELECT projectName FROM Projects INNER JOIN ProjectUsers ON ProjectUsers.employeeId = $row3[employeeId]";

				$stmt4 = $conn->query($sqlFour);

				$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

				echo "<tr><td>".$groupName."</td>
				<td>".$row4['projectName']."</td>
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

	// Else if the search bool is true - we re-search - Allow for users to re-search for Group name/Employee name/email
	else if ($searchBool == true)
	{
		$searchFor = $_POST['searchGroup'];







	}








		?>




	</tbody>
</table>





</body>
</HTML>