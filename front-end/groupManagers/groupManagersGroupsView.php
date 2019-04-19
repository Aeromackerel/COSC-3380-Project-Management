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
				<input type="text" class="form-control2" name ="employeeFind" placeholder="searchForEmployee">
 				<button type = "submit" name = "searchEmployee" class="btn btn-info">Search</button>	
 			</div>
 	</form>
 </center>
	
 	

<table class = "table">
		<thead>
			<tr>
				<th> Group Member's Name </th>
				<th> Group Member's Email</th>
				<th> Group Member's Phone Number</th>
				<th> Role </th>
				<th> Related to Project </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";
		// Creating Enumerated types via arrays again
		$roleIdArray = array("", "Employee", "Manager", "Project Manager");
		// Query for initial Groups that the user is involved in
		$sqlOne = "SELECT groupId FROM GroupsUsers WHERE employeeId = $tempUserID";
		$stmt = $conn->query($sqlOne);

		$searchBool = false;

			if (isset($_POST['searchEmployee']))
			{

				$sql2= "SELECT groupId From GroupsUsers WHERE employeeId = $tempUserID";
				$stmt2 = = $conn->query($sql2);

			    if($searchBool == true)
			{
			    $sqlFour = "SELECT firstName, lastName, phoneNumber, email, role FROM Employees WHERE employeeId = $tempUserID AND taskName LIKE '%$_POST[employeeFind]%'";

				$stmt4 = $conn->query($sqlFour);

			    while ($row2 = $stmt4->fetch(PDO::FETCH_ASSOC))
			    {
			    		echo "<tr>
						<td>".$row2['firstName' ,'lastName']."</td>
						<td>".$row2['phoneNumber']."</td>
						<td>".$statusName[$row2['email']]."</td>
						<td>".$row2['role']."</td>
						<td>  <a href='actions/editEmployeesInfo.php?edit=$row2[employeeId]><button type= button name = 'edit' class='btn btn-info'> Edit </button></a> <br>
						</td> </tr>";
			    }

			}
			}
		$stmt3 = $conn->query($sql3);
		while ($row = $stmt3->fetch(PDO::FETCH_ASSOC))
		{
		// Query for all employeeIds - given the groups that they're involved in
		$sql4= "SELECT employeeId FROM GroupsUsers WHERE groupId = $row[groupId]";
		// Query for the information and output to the table
		$stmt4 = $conn->query($sqlFour);
			// Query for all employee information given the employeeIds we queried from earlier
			while ($row2 = $stmt4->fetch(PDO::FETCH_ASSOC))
			{
				$sqlThree = "SELECT firstName, lastName, employeeId, email, phoneNumber, role FROM Employees WHERE Employees.employeeId = $row2[employeeId]";
				$stmt3 = $conn->query($sqlThree);
				while ($row3 = $stmt4->fetch(PDO::FETCH_ASSOC))
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