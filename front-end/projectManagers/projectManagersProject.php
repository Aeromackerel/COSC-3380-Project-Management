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

<title> Projects Overview </title>
<link rel = "stylesheet" href = "../bootstrap.css">
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

	<a href = 'actions/addProjectManagersProject.php'><button type="button" name = "addProject" class="btn btn-success float-right btn-space">Add Project</button> </a>
	<a href = 'actions/removeProjectManagersProject.php'><button type ="button" name = "removeProject" class = "btn btn-info float-right btn-space"> Edit Project </button></a>

	<table class = "table">
	<thead>
			<tr>
				<th> Belongs to Department </th>
				<th> Project Name </th>
				<th> Status </th>
				<th> Start Date </th>
				<th> Predicted Date </th>
				<th> Actual End Date </th>
				<th> Project Client</th>
			</tr>
		</thead>
		<tbody>


		<?php

		// Connection to Database

		include "../../includes/dbconnect.ini.php";

		$sqlQueryProjects = "SELECT projectName, startDate, actualEndDate, predictedEndDate, projectClient, statusID, Departments.departmentName FROM Projects INNER JOIN Departments ON Projects.departmentId = Departments.departmentId";

		$stmtQueryProjects = $conn->query($sqlQueryProjects);

		while ($rowProjects = $stmtQueryProjects->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr><td>".$rowProjects['departmentName']."</td>
			<td>". $rowProjects['projectName'] ." </td>
			<td>". $statusName[$rowProjects['statusID']] ."</td>
			<td>". $rowProjects['startDate'] ."</td>
			<td>". $rowProjects['predictedEndDate'] ."</td>
			<td>". $rowProjects['actualEndDate']."</td>
			<td>". $rowProjects['projectClient']."</td>
			</tr>"; 
		}


		?>
	</tbody>
</table>
</body>
