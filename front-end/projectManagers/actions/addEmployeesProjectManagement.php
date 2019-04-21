<?php
session_start();
if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}

$tempUserId = $_SESSION['userID'];

include "../../../includes/dbconnect.ini.php";

if (isset($_POST['submitChanges']))
{
	$projectId = (int)$_POST['relatedProjectCreate'];
	$employeeId = (int)$_POST['relatedEmployeeCreate'];

	$sqlInsert = "IF NOT EXISTS(SELECT * FROM ProjectUsers WHERE employeeId = $employeeId AND projectId = $projectId) INSERT INTO ProjectUsers(employeeId, projectId)
	VALUES($employeeId,$projectId)";
	$conn->query($sqlInsert);
	header ("Location: ../projectManagersEmployees.php");

}

else if (isset($_POST['goBack']))
	{header ("Location: ../projectManagersEmployees.php");}
?>

<!----- HTML Section ----->
<!DOCTYPE HTML>
<title>Add employees to Event</title>
<link rel="stylesheet"type="text/css"href="../../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="../projectManagersIndex.php"> Back to Index </a>
				<a href="../../actionLogOut.php">Sign out</a>
			</div>
		</div>
	</div>

	<div id = "login-container" class = "ui-container">
		<form method = "post">
		<center>
		 <div class="form-group">
		 	<label class="mr-sm-2" for="inlineFormCustomSelect">Project Name</label>
			<select class="custom-select mr-sm-2" name = "relatedProjectCreate" id="inlineFormCustomSelect">
				<?php
				//Include DB connection file
				include "../../../includes/dbconnect.ini.php";

				// Query for all projects that a Project Manager is managing

				$sqlQueryProjects = "SELECT projectId, projectName FROM Projects WHERE projectManagerId = $tempUserId";

				$stmtOne = $conn->query($sqlQueryProjects);

				while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
				{
				echo "<option value=".$rowOne['projectId'].'">'.$rowOne['projectName'].'</option>';
				}
				?>
			</select>
			<label class="mr-sm-2" for="inlineFormCustomSelect">Employee Name</label>
			<select class="custom-select mr-sm-2" name = "relatedEmployeeCreate" id="inlineFormCustomSelect">

				<?php
				//Include DB connection file
				include "../../../includes/dbconnect.ini.php";

				// Query for all employees that isn't in the project

				$sqlQueryProjects = "SELECT DISTINCT projectId, projectName FROM Projects WHERE projectManagerId != $tempUserId";

				$stmtOne = $conn->query($sqlQueryProjects);

				while ($rowOne = $stmtOne->fetch(PDO::FETCH_ASSOC))
				{
					$sqlQueryEmployees = "SELECT DISTINCT Employees.employeeId, firstName, lastName FROM Employees INNER JOIN ProjectUsers ON Employees.employeeId = ProjectUsers.employeeId WHERE ProjectUsers.projectId = $rowOne[projectId]";
					$stmtTwo = $conn->query($sqlQueryEmployees);

					while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
					{
						echo "<option value=".$rowTwo['employeeId'].'">'.$rowTwo['firstName']." ".$rowTwo['lastName'].'</option>';
					}
					
				}

				?>
			</select>



			<button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 	<button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>


		</div>
	</form>

</center>

	</div>

	</body>


</HTML>