<!---- PHP Section ---->
<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.

	if (!$_SESSION['loggedin'])
	{header ("Location: ../../login.php");}

	$tempUserID = (int)$_SESSION['userID'];


	// Include DB connection
 	include "../../../includes/dbconnect.ini.php";

 	// If button is pressed then we'll generate the task

 	if (isset($_POST['submitChanges']))
 	{
 		$taskName = $_POST['taskNameCreate'];
 		$description = $_POST['descriptionCreate'];
 		$endDate =  $_POST['endDateCreate'];
 		$projectId = (int)$_POST['relatedProjectCreate'];
 		$statusNotes = $_POST['statusNoteCreate'];

 		$fieldsFilled = true;

 		// If the fields are empty

 		if (empty($taskName) || empty($description) || empty($endDate) || empty($projectId))
 			{$fieldsFilled = false;}

 		if ($fieldsFilled == true)
 		{
 		$sqlCreateTask = "INSERT INTO TASKS (projectId, taskName, status, statusNotes, desiredEndDateTime, description, employeeId, deleteFlagStatus) VALUES
 		($projectId, '$taskName', 1, '$statusNotes', '$endDate', '$description', $tempUserID, 0)";
 		$stmt = $conn->query($sqlCreateTask);

 		header ("Location: ../usersTaskView.php");
 		}
 	}

 	else if (isset($_POST['goBack']))
 	{header ("Location: ../usersTaskView.php");}



?>




<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">



<div id="login-container" class="ui-container">
	<center>
		<form method = "post">
		 <div class="form-group">
		   <label for="Task Name">Task Name</label>
		   <input type="text" class="form-control" name ="taskNameCreate" placeholder="Task Name">

		   <label for = "Description"> Description </label>
		   <input type = "text" class = "form-control" name = "descriptionCreate" placeholder = "Description">

		   <label for = "statusNote"> Status Notes </label>
		   <input type = "text" class = "form-control" name = "statusNoteCreate" placeholder = "Not available">

		   <label for = "endDate"> Expected End Date </label>
		   <input type = "date" class = "form-control" name= "endDateCreate" placeholder = "2019-05-01">

		<label class="mr-sm-2" for="inlineFormCustomSelect">Under Project</label>
		<select class="custom-select mr-sm-2" name = "relatedProjectCreate" id="inlineFormCustomSelect">

			<!----- Query for projects that a user belongs to ----->

			<?php

				// Initialize DB connection

				include "../../../includes/dbconnect.ini.php";

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
      	 <button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 <button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>
	</form>

	</center>
</div>




</HTML>
