<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

if (isset($_POST['goBack']))
{header ("Location: projectManagersIndex.php");}
else if (isset($_POST['submit']))
{
	header ("Location: actions/generateEmployeeReport.php?report=$_POST[relatedEmployeeGen]&from=$_POST[fromDateCreate]&to=$_POST[toDateCreate]");
}

?>


<!DOCTYPE HTML>
<title>Project Costs Report</title>
<link rel="stylesheet"type="text/css"href="../users/bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="projectManagersIndex.php"> Back to Index </a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<form method = "post">
	<div id = "login-container" class = "ui-container">
		<center><p> Employee Report </p></center>
		<center><label class="mr-sm-2" for="inlineFormCustomSelect">Employee assigned to Project</label></center>
		<select class="custom-select mr-sm-2" name = "relatedEmployeeGen" id="inlineFormCustomSelect">

			<?php
				// Initialize DB connection
				include "../../includes/dbconnect.ini.php";
				// Query for projects that a user is assigned to
				$sqlProjectsUser = "SELECT DISTINCT projectId FROM ProjectUsers WHERE employeeId = $tempUserID";
				$stmtFindProjects = $conn->query($sqlProjectsUser);
				while ($rowProjectID = $stmtFindProjects->fetch(PDO::FETCH_ASSOC))
				{
				// Query for projects that a user might belong to
				$sqlFindProjectsUser = "SELECT DISTINCT Projects.projectId, Projects.projectName, ProjectUsers.employeeId FROM Projects INNER JOIN ProjectUsers ON Projects.projectId = $rowProjectID[projectId] ";
				$stmtFindProject = $conn->query($sqlFindProjectsUser);
				while ($rowProject = $stmtFindProject->fetch(PDO::FETCH_ASSOC))
				{	
					$sqlFindEmployees = "SELECT firstName, lastName FROM Employees WHERE employeeId = $rowProject[employeeId]";
					$stmtFindEmployees = $conn->query($sqlFindEmployees);
					while ($rowEmployee = $stmtFindEmployees->fetch(PDO::FETCH_ASSOC))
					{
						$eFirstName = $rowEmployee['firstName'];
						$eLastName = $rowEmployee['lastName'];
						$projectId = $rowProject['projectId'];
						$projectName = $rowProject['projectName'];
						$employeeId = $rowProject['employeeId'];
						 echo '<option value="'.$projectId.' '.$employeeId.'">'.$projectName." - ".$eFirstName. " ". $eLastName.'</option>';

					}
				}
			}
			?>
		</select>
				<center>
				<label for = "fromDate"> From: </label>
			 <input type = "date" class = "form-control" name= "fromDateCreate" placeholder = "2019-05-01">
		 </center>
		 <center>
			 <label for = "toDate"> To: </label>
			<input type = "date" class = "form-control" name= "toDateCreate" placeholder = "2019-05-01">
		</center>
      	<center>
      	<button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		<button type="submit" name = "submit" class="btn btn-primary btn-space2">Submit</button>
		</center>
		</form>

	</div>
</body>
<HTML>