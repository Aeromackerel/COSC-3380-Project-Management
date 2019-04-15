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
<body background = "../images/workBG.jpg">
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="userIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>

	<!----- In line form to search for a group member 

	<form class = "form-inline" method = post>
		<label class = "sr-only" for = "inlineFormInputName2"> Employee First Name </label>
		<input type = "text" name = "employeeFirstNameSearch" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "Employee first name">

		<label class = "sr-only" for = "inlineFormInputName2"> Employee Last Name </label>
		<input type = "text" name = "employeeLastNameSearch" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "Employee last name">

		<button type = "submit" class = "btn btn-primary nam" name = "submit-button"> Search for Employee </button>
	</form>

	----->

	<?php

	/** Connects to the SQL server so we an find what the user might be looking for

	include "../../includes/dbconnect.ini.php";

	if (isset($_POST['submit-button']))
	{
		$employeeFirstName = $_POST['employeeFirstNameSearch'];
		$employeeLastName = $_POST['employeeLastNameSearch'];

		$sqlFindQuery = "SELECT firstName, lastName, employeeId, email, phoneNumber, role FROM Employees WHERE Employees.firstName = '$employeeFirstName' AND Employees.lastName ='$employeeLastName'";

		$stmtFind = $conn->query($sqlFindQuery);

		$rowResult = $stmtFind->fetch(PDO::FETCH_ASSOC);

		$searchBool = true;
	}
		*/
	?>









<table class = "table">
		<thead>
			<tr>
				<th> Group Member's Name </th>
				<th> Group Member's ID</th>
				<th> Group Member's Email</th>
				<th> Group Member's Phone Number</th>
				<th> Role </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";

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

					// Print to the table

				echo "<tr><td>".$row3['firstName']." ".$row3['lastName']."</td>
				<td>".$row3['employeeId']."</td>
				<td>".$row3['email']."</td>
				<td>".$row3['phoneNumber']."</td>
				<td>".$row3['role']."</td>
				</tr>"
				;
				}



			}

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