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
				<th> Task name </th>
				<th> Description </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Expected End Date </th>
				<th> Actual End Date </th>
				<th></th>
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
			    $sqlTwo = "SELECT taskId, taskName, description, status, statusNotes, startDate, desiredEndDateTime, actualEndDateTime FROM Tasks WHERE employeeId = $tempUserID AND taskName LIKE '%$_POST[taskFind]%'";
				$stmt2 = $conn->query($sqlTwo);
			    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
			    {
			    		echo "<tr>
						<td>".$row2['taskName']."</td>
						<td>".$row2['description']."</td>
						<td>".$statusName[$row2['status']]."</td>
						<td>".$row2['statusNotes']."</td>
						<td>".$row2['startDate']."</td>
						<td>".$row2['desiredEndDateTime']."</td>
						<td>".$row2['actualEndDateTime']."</td>
						<td>  <a href='actions/editTasksUsers.php?edit=$row2[taskId]><button type= button name = 'edit' class='btn btn-info'> Edit </button></a> <br>
						</td> </tr>";
			    }
			}
			else{
				// Query for userID with the session email that we have from the session
				$sqlOne = "SELECT taskId, taskName, description, status, statusNotes, startDate, desiredEndDateTime, actualEndDateTime FROM Tasks WHERE employeeId = $tempUserID ORDER BY desiredEndDateTime";
				// Prints to the table so what they have
				$stmt = $conn->query($sqlOne);
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					echo "<tr>
					<td>".$row['taskName']."</td>
					<td>".$row['description']."</td>
					<td>".$statusName[$row['status']]."</td>
					<td>".$row['statusNotes']."</td>
					<td>".$row['startDate']."</td>
					<td>".$row['desiredEndDateTime']."</td>
					<td>".$row['actualEndDateTime']."</td>
					<td>  <a href='actions/editTasksProjectManagement.php?edit=$row[taskId]><button type= button name = 'edit' class='btn btn-info'> Edit </button></a> <br>
					</td> </tr>";
				}
			}
			?>



		</tbody>
	</table>

</body>

<HTML>