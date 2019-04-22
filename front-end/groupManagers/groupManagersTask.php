<?php

// start session and check if the roleId is == 2

session_start();

// Redirects user to the log in page if they aren't logged in and if they don't have groupManagers privileges

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

// Creating Enumerated types via arrays
$statusName = array("", "No Progress", "Early Stages", "In Progress", "Almost Finished", "Finished");


?>

<!----- HTML SECTION ----->
<DOCTYPE HTML>
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
	<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="taskFind" placeholder="Search for Task">
 		<button type = "submit" name = "searchTask" class="btn btn-info">search</button> 
 	</div>
 	</form>
 	</center>


 	<a href = 'actions/addTasksGroupManagersSelf.php'><button type="button" name = "addTask" class="btn btn-success float-right btn-space">Add Task</button> </a>

	<table id = "tasksTable" class = "table">
		<thead>
			<tr>
				<th> Related to Project </th>
				<th> Task name </th>
				<th> Description </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Expected End Date </th>
				<th> Edit task </th>
			</tr>
		</thead>
		<tbody>


<!------ DB connection and Query ------->

			<?php

			// Connection to the DB

			include "../../includes/dbconnect.ini.php";

			$searchBool = false;

			if (isset($_POST['searchTask']))
				{$searchBool = true;}


			    if($searchBool == true)
			    {
			    $sqlTwo = "SELECT taskId, projectName, taskName, description, status, statusNotes, Tasks.startDate, Tasks.desiredEndDateTime FROM Tasks INNER JOIN Projects ON Tasks.projectId = Projects.projectId WHERE employeeId = $tempUserID AND taskName LIKE '%$_POST[taskFind]%'";

				$stmt2 = $conn->query($sqlTwo);

			    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
			    {
			    		echo "<tr><td>".$row2['projectName']."</td>
						<td>".$row2['taskName']."</td>
						<td>".$row2['description']."</td>
						<td>".$statusName[$row2['status']]."</td>
						<td>".$row2['statusNotes']."</td>
						<td>".$row2['startDate']."</td>
						<td>".$row2['desiredEndDateTime']."</td>
						<td>  <a href='actions/editTasksGroupManagersSelf.php?edit=$row2[taskId]><button type= button name = 'edit' class='btn btn-info'> Edit </button></a> <br>
						</td> </tr>";
			    }

			}

			else{

				// Query for userID with the session email that we have from the session

				$sqlOne = "SELECT taskId, projectName, taskName, description, status, statusNotes, Tasks.startDate, Tasks.desiredEndDateTime FROM Tasks INNER JOIN Projects ON Tasks.projectId = Projects.projectId WHERE employeeId = $tempUserID ORDER BY desiredEndDateTime";

				// Prints to the table so what they have

				$stmt = $conn->query($sqlOne);
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					echo "<tr><td>".$row['projectName']."</td>
					<td>".$row['taskName']."</td>
					<td>".$row['description']."</td>
					<td>".$statusName[$row['status']]."</td>
					<td>".$row['statusNotes']."</td>
					<td>".$row['startDate']."</td>
					<td>".$row['desiredEndDateTime']."</td>
					<td>  <a href='actions/editTasksGroupManagersSelf.php?edit=$row[taskId]><button type= button name = 'edit' class='btn btn-info'> Edit </button></a> <br>
					</td> </tr>";
				}

			}
			?>
		</tbody>
	</table>

</body>
	
</HTML>
