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
	<center>
	<form method = "post">
	


	<a href = 'actions/addTasksGroupManagersEmployee.php'><button type="button" name = "addTask" class="btn btn-success float-right btn-space">Add Task</button> </a>
	<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="taskFind" placeholder="Search for Task">
 		<button type = "submit" name = "searchTask" class="btn btn-info">search</button> 
 	</div>
 	</form>
 	</center>

	<!---- Left join on Employees/Tasks table ----->

		<table id = "tasksTable" class = "table">
		<thead>
			<tr>
				<th> Task name </th>
				<th> Related to Project </th>
				<th> Employee Name </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Estimated End Date </th>
				<th> Actual End Date </th>
			</tr>
		</thead>
		<tbody>

<!------ DB connection and Query ------->

			<?php

			// Connection to the DB

			include "../../includes/dbconnect.ini.php";

			// Boolean to check whether or not the search Task was pressed
			$statusName = array("", "No progress", "Early Stages", "In Progress", "Almost Finished", "Finished");

			// Array for groupId
			$groupManagerArray = array();

			$sqlFindGroups = "SELECT groupId FROM GroupsUsers WHERE employeeId = $tempUserID";

			$stmt = $conn->query($sqlFindGroups);

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{array_push ($groupManagerArray, $row['groupId']);}

			$searchBool = false;

			if (isset($_POST['searchTask']))
			{
				// Look for groupIds of the groupManager

				$sqlOne = "SELECT groupId From GroupsUsers WHERE employeeId = $tempUserID";

				$stmtOne = $conn->query($sqlOne);

				// While loop to pull all the employee Ids using the given groupId

				while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
				{
					$sqlTwo = "SELECT employeeId FROM GroupsUsers WHERE groupId = $rowOne[groupId]";

					$stmtTwo = $conn->query($sqlTwo);

					while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
					{
						// Query for Task information

						$sqlThree = "SELECT taskId, projectId, employeeId, taskName, startDate, actualEndDateTime, desiredEndDateTime, description, status, statusNotes FROM Tasks WHERE employeeId = $rowTwo[employeeId] AND employeeId != $tempUserID AND taskName LIKE '%$_POST[taskFind]%'";

						$stmtThree = $conn->query($sqlThree);

						while ($rowThree = $stmtThree->fetch(PDO::FETCH_ASSOC))
						{
							// Query for project Name

							$sqlThreeProject = "SELECT projectName FROM Projects WHERE projectId = $rowThree[projectId]";

							$stmtThreeProject = $conn->query($sqlThreeProject);

							$rowThreeProject = $stmtThreeProject->fetch(PDO::FETCH_ASSOC);

							// Query for employee Names

							$sqlThreeEmployee = "SELECT firstName, lastName FROM Employees WHERE employeeId = $rowThree[employeeId]";

							$stmtThreeEmployee = $conn->query($sqlThreeEmployee);

							$rowThreeEmployee = $stmtThreeEmployee->fetch(PDO::FETCH_ASSOC);

						echo "<tr>
						<td>".$rowThree['taskName']."</td>
						<td>".$rowThreeProject['projectName']."</td>
						<td>".$rowThreeEmployee['firstName']." ".$rowThreeEmployee['lastName']."</td>
						<td>".$statusName[$rowThree['status']]."</td>
						<td>".$rowThree['statusNotes']."</td>
						<td>".$rowThree['startDate']."</td>
						<td>".$rowThree['desiredEndDateTime']."</td>
						<td>".$rowThree['actualEndDateTime']."</td>
						</td> </tr>";

						}

					}
				}
			}

			// Query for everything else - CHANGE THIS PART, so we can query for all employees that are related in a group

			else{

				foreach($groupManagerArray as $groupID)
				{
					$sqlTwo = "SELECT employeeId FROM GroupsUsers WHERE groupId = $groupID";

					$stmtTwo = $conn->query($sqlTwo);

					while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
					{
						// Query for Task information

						$sqlThree = "SELECT taskId, projectId, employeeId, taskName, startDate, actualEndDateTime, desiredEndDateTime, description, status, statusNotes FROM Tasks WHERE employeeId = $rowTwo[employeeId] AND employeeId != $tempUserID";

						$stmtThree = $conn->query($sqlThree);

						while ($rowThree = $stmtThree->fetch(PDO::FETCH_ASSOC))
						{
							// Query for project Name

							$sqlThreeProject = "SELECT projectName FROM Projects WHERE projectId = $rowThree[projectId]";

							$stmtThreeProject = $conn->query($sqlThreeProject);

							$rowThreeProject = $stmtThreeProject->fetch(PDO::FETCH_ASSOC);

							// Query for employee Names

							$sqlThreeEmployee = "SELECT firstName, lastName FROM Employees WHERE employeeId = $rowThree[employeeId]";

							$stmtThreeEmployee = $conn->query($sqlThreeEmployee);

							$rowThreeEmployee = $stmtThreeEmployee->fetch(PDO::FETCH_ASSOC);

						echo "<tr>
						<td>".$rowThree['taskName']."</td>
						<td>".$rowThreeProject['projectName']."</td>
						<td>".$rowThreeEmployee['firstName']." ".$rowThreeEmployee['lastName']."</td>
						<td>".$statusName[$rowThree['status']]."</td>
						<td>".$rowThree['statusNotes']."</td>
						<td>".$rowThree['startDate']."</td>
						<td>".$rowThree['desiredEndDateTime']."</td>
						<td>".$rowThree['actualEndDateTime']."</td>
						</td> </tr>";

						}

					}
				}
			}
			?>

		</tbody>
	</table>



</body>

<HTML>