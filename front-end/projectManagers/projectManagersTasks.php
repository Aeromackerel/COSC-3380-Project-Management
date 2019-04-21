<!----- PHP Section ----->

<?php
session_start();
// If user isn't logged in then they will be redirected back to the log in page.
if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}
$tempUserID = (int)$_SESSION['userID'];
// Creating Enumerated types via arrays
$statusName = array("", "No Progress", "Early Stages", "In Progress", "Almost Finished", "Finished");
?>

<!--- HTML SECTION ----->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../bootstrap.css">
<title> Tasks Overview </title>
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

	<center>
	<form method = "post">
	<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="taskFind" placeholder="Search for Task">
 		<button type = "submit" name = "searchTask" class="btn btn-info">search</button>
 	</div>
 	</form>
 	</center>

 	<a href = 'actions/addTasksProjectManagement.php'><button type="button" name = "addTask" class="btn btn-success float-right btn-space">Add Task</button> </a>
	<table id = "tasksTable" class = "table">
		<thead>
			<tr>
				<th> Under Project </th>
				<th> Belongs to Employee </th>
				<th> Task name </th>
				<th> Description </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Expected End Date </th>
				<th> Actual End Date </th>
			</tr>
		</thead>
		<tbody>

	<!------ DB connection and Query ------->

			<?php
			// Connection to the DB
			include "../../includes/dbconnect.ini.php";
			$searchBool = false;
			// Query for Projects that a project Manager is involved
			if (isset($_POST['searchTask']))
				{$searchBool = true;}
			    if($searchBool == true)
			    {
			    $findtask = $_POST['taskFind'];
				$sqlOne = "SELECT projectName, Projects.projectId, employeeId FROM ProjectUsers INNER JOIN Projects ON ProjectUsers.projectId = Projects.projectId WHERE Projects.projectManagerId = $tempUserID";

				$stmtOne = $conn->query($sqlOne);

				while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
				{
					$sqlTwo = "SELECT taskName, description, status, statusNotes, startDate, desiredEndDateTime, actualEndDateTime, firstName, lastName FROM Tasks INNER JOIN Employees ON Tasks.employeeId = Employees.employeeId WHERE Tasks.employeeId = $rowOne[employeeId] AND Tasks.employeeId != $tempUserID AND Tasks.taskName LIKE '%$findtask%'";

					$stmtTwo = $conn->query($sqlTwo);

					while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr>
						<td>".$rowOne['projectName']."</td>
						<td>".$rowTwo['firstName']." ". $rowTwo['lastName'] ."</td>
						<td>".$rowTwo['taskName']."</td>
						<td>".$rowTwo['description']."</td>
						<td>".$statusName[$rowTwo['status']]."</td>
						<td>".$rowTwo['statusNotes']."</td>
						<td>".$rowTwo['startDate']."</td>
						<td>".$rowTwo['desiredEndDateTime']."</td>
						<td>".$rowTwo['actualEndDateTime']."</td> 
						</tr>";
					}
				}

			}
			else{
				$sqlOne = "SELECT projectName, Projects.projectId, employeeId FROM ProjectUsers INNER JOIN Projects ON ProjectUsers.projectId = Projects.projectId WHERE Projects.projectManagerId = $tempUserID";

				$stmtOne = $conn->query($sqlOne);

				while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
				{
					$sqlTwo = "SELECT taskName, description, status, statusNotes, startDate, desiredEndDateTime, actualEndDateTime, firstName, lastName FROM Tasks INNER JOIN Employees ON Tasks.employeeId = Employees.employeeId WHERE Tasks.employeeId = $rowOne[employeeId] AND Tasks.employeeId != $tempUserID";

					$stmtTwo = $conn->query($sqlTwo);

					while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
					{
						echo "<tr>
						<td>".$rowOne['projectName']."</td>
						<td>".$rowTwo['firstName']." ". $rowTwo['lastName'] ."</td>
						<td>".$rowTwo['taskName']."</td>
						<td>".$rowTwo['description']."</td>
						<td>".$statusName[$rowTwo['status']]."</td>
						<td>".$rowTwo['statusNotes']."</td>
						<td>".$rowTwo['startDate']."</td>
						<td>".$rowTwo['desiredEndDateTime']."</td>
						<td>".$rowTwo['actualEndDateTime']."</td> 
						</tr>";
					}
				}

				
			}
			?>



		</tbody>
	</table>

</body>

<HTML>