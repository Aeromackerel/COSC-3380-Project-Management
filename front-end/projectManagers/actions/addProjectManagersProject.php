<!-- PHP Section ---->
<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.
	if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
	{header ("Location: ../../login.php");}

	$tempUserID = (int)$_SESSION['userID'];

	// Include DB connection

 	include "../../../includes/dbconnect.ini.php";

 	// If button is pressed then we'll generate the task
 	if (isset($_POST['submitChanges']))
 	{
 			$projectName=$_POST['projectNameCreate'];
 			$departmentId =$_POST['relatedDepartmentCreate'];
 			$projectClient=$_POST['projectClientCreate'];
 			$startDate=$_POST['projectStartDateCreate'];
 			$expectedEndDate=$_POST['projectExpectedEndDateCreate'];

   		$sqlCreateProject = "INSERT INTO Projects (statusId, projectManagerId, startDate, predictedEndDate, projectName, projectClient,deleteFlagStatus, departmentId) VALUES 
   		(1, $tempUserID, '$startDate', '$expectedEndDate', '$projectName', '$projectClient', 0, $departmentId)";
 		 $stmt = $conn->query($sqlCreateProject);
 		 header ("Location: ../projectManagersProject.php");
 		
 	}
 	else if (isset($_POST['goBack']))
 	{header ("Location: ../projectManagersProject.php");}
?>




<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">



<div id="login-container" class="ui-container">
	<center>
		<form method = "post">
		 <div class="form-group">
		   <label for="projectName">Project Name</label>

		   <input type="text" class="form-control" name ="projectNameCreate" placeholder="Project Name">
		   <label for = "Department"> Belongs to Department </label>
		   <select class="custom-select mr-sm-2" name = "relatedDepartmentCreate" id="inlineFormCustomSelect">
		   	<?php

		   		$sqlDepartmentFind = "SELECT departmentId, departmentName FROM Departments";

		   		$stmtDepartmentFind = $conn->query($sqlDepartmentFind);

		   		while ($rowOne = $stmtDepartmentFind->fetch(PDO::FETCH_ASSOC))
		   		{
		   			echo '<option value="'.$rowOne['departmentId'].'">'.$rowOne['departmentName'].'</option>';
		   		}


		   	?>
		   </select>

		   <label for = "projectClient"> For Client </label>
		   <input type ="text" class="form-control" name="projectClientCreate" placeholder="Project Client">
		   <label for = "startDate"> Start Date </label>
		   <input type="date" class="form-control" name ="projectStartDateCreate" placeholder="Start Date">
		   <label for = "desiredEndDate"> Expected End Date </label>
		   <input type="date" class="form-control" name ="projectExpectedEndDateCreate" placeholder="Expected End Date">

      	 <button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 <button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>
	</form>

	</center>
</div>




</HTML>