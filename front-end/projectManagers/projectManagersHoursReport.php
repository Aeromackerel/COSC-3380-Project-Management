<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}

// Store session

$tempUserID = (int)$_SESSION['userID'];
$roleID = (int)$_SESSION['roleID'];

// Takes them back to the index

if (isset($_POST['goBack']))
{header ("Location: projectManagersIndex.php");}

// If submit - then we take the user to another page to generate a Report on the given project ID

else if (isset($_POST['submit']))
{header ("Location: actions/generateProjectReport.php?report=$_POST[relatedProjectGen]&from=$_POST[fromDateCreate]&to=$_POST[toDateCreate]");}


?>


<!DOCTYPE HTML>
<title>Project Hours Report</title>
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
		<center><p> Project Hours Report </p></center>
		<center><label class="mr-sm-2" for="inlineFormCustomSelect">Project Name</label></center>
		<select class="custom-select mr-sm-2" name = "relatedProjectGen" id="inlineFormCustomSelect">

			<!----- Query for projects that a user belongs to ----->

			<?php

				// Initialize DB connection

				include "../../includes/dbconnect.ini.php";

				// Query for projects that a user is assigned to

				$sqlProjectsUser = "SELECT DISTINCT projectId FROM ProjectUsers WHERE employeeId = $tempUserID";

				$stmtFindProjects = $conn->query($sqlProjectsUser);

				while ($rowProjectID = $stmtFindProjects->fetch(PDO::FETCH_ASSOC))
				{

				// Query for projects that a user might belong to

				$sqlFindProjectsUser = "SELECT DISTINCT Projects.projectId, Projects.projectName FROM Projects INNER JOIN ProjectUsers ON Projects.projectId = $rowProjectID[projectId] ";

				$stmtFindProject = $conn->query($sqlFindProjectsUser);
				while ($rowProject = $stmtFindProject->fetch(PDO::FETCH_ASSOC))
				{
					unset($projectIdOption, $projectNameOption);
					$projectIdOption = $rowProject['projectId'];
					$projectNameOption = $rowProject['projectName'];

					 echo '<option value="'.$projectIdOption.'">'.$projectNameOption.'</option>';

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


		</select>
	</div>
</body>
<HTML>
