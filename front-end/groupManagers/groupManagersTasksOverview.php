<!----- PHP Section ----->

<?php
session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

?>

<!----- HTML Section ----->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../users/bootstrap.css">
<title> Tasks Overview </title>
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

	<!----- Inline form to assign employee's new tasks ----->
	<form class = "form-inline" method = post>
		<label class = "sr-only" for = "inlineFormInputName2"> taskName </label>
		<input type = "text" name = "taskNameCreate" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "task Name">

		<label class = "sr-only" for = "inlineFormInputName2"> Related To Project Name </label>
		<input type="text" name = "projectNameCreate" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Project Name">

		<label class = "sr-only" for = "inlineFormInputName2"> Desired End Date (YYYY-MM-DD) </label>
		<input type = "text" name = "desiredEndDateCreate" class = "form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder = "2019-05-01">

		<label class = "sr-only" for = "inlineFormInputName2"> Description </label>
		<input type = "text" name = "descriptionCreate" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "Sample Description">

		<label class = "sr-only" for = "inlineFormInputName2"> Employee ID </label>
		<input type = "text" name = "employeeIdCreate" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "EmployeeID">

            <button type = "submit" class = "btn btn-primary nam" name = "submit-button"> Add Task </button>
	</form>


	<!----- PHP section to ADD a new Task ----->
	<?php
	if (isset($_POST['submit-button']))
	{

	// Connection to the DB

	include "../../includes/dbconnect.ini.php";

	// Query for Project Name

	$projectName = $_POST['projectNameCreate'];

	$sqlQueryProjectID = "SELECT projectId from Projects WHERE projectName ='$projectName'";

	$stmt= $conn->query($sqlQueryProjectID);

	$rowProjectId = $stmt->fetch(PDO::FETCH_ASSOC);

	$projectIdFound = $rowProjectId['projectId'];

	// Using form data to create the entity in the table

	$taskName = $_POST['taskNameCreate'];
	$endDate = $_POST['desiredEndDateCreate'];
	$description = $_POST['descriptionCreate'];
	$employeeID = (int)$_POST['employeeIdCreate'];

	$sqlCreateQuery = "INSERT INTO Tasks(projectId, taskName, status, desiredEndDateTime, description, employeeId, deleteFlagStatus)
	VALUES('$projectIdFound', '$taskName', 1, '$endDate', '$description', '$employeeID', 0)";

	$stmt=$conn->query($sqlCreateQuery);

	}


	?>


	<!---- Left join on Employees/Tasks table ----->

		<table id = "tasksTable" class = "table">
		<thead>
			<tr>
				<th> Task name </th>
				<th> Employee Name </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Actual End Date </th>
			</tr>
		</thead>
		<tbody>

		<!------ DB connection and Query ------->

		<?php

		// Connection to the DB

		include "../../includes/dbconnect.ini.php";

		// Array for enumerated Types
		$statusName = array("", "No Progress", "Early Stages", "In Progress", "Almost Finished", "Finished");

		// Now we want to run a query on groupUsers to find all Employees

			$sqlThree = "SELECT taskId, taskName, Employees.employeeId, firstName, lastName, status, statusNotes, startDate, actualEndDateTime FROM Tasks INNER JOIN Employees ON Tasks.employeeId = Employees.employeeId ORDER BY Status DESC";

			$stmt3 = $conn->query($sqlThree);

			while ($rowThree = $stmt3->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr>
				<td>".$rowThree['taskName']."</td>
				<td>".$rowThree['firstName']. " ". $rowThree['lastName']."</td>
				<td>".$statusName[$rowThree['status']]."</td>
				<td>".$rowThree['statusNotes']."</td>
				<td>".$rowThree['startDate']."</td>
				<td>".$rowThree['actualEndDateTime']."<td>
				</tr>"
				;
			}





		?>
		</tbody>
	</table>



</body>

<HTML>