<!---- Initial PHP ----->

<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.
	if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
	{header ("Location: ../../login.php");}

	$tempUserID = (int)$_SESSION['userID'];

	// Include DB connection

 	include "../../../includes/dbconnect.ini.php";


 	if (isset($_POST['goBack']))
 		{header("Location: ../projectManagersProject.php");}

 	else if (isset($_POST['submitChanges']))
 	{
 		$departmentId = $_POST['relatedDepartmentCreate'];
 		$projectId = $_POST['relatedProjectCreate'];
 		$statusId = $_POST['statusChange'];
 		$predictedEndDate = $_POST['endDateCreate'];

 		if (empty($predictedEndDate))
 		{
 			$sqlQueryForPredictedEndDate = "SELECT predictedEndDate FROM Projects WHERE projectId = $projectId";
 			$stmtTwo = $conn->query($sqlQueryForPredictedEndDate);
 			$rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC);
 			$predictedEndDate = $rowTwo['predictedEndDate'];
 		}

 		$sqlQuery = "UPDATE Projects SET departmentId = $departmentId, statusID = $statusId, predictedEndDate = '$predictedEndDate' WHERE projectId = $projectId";

 		$conn->query($sqlQuery);
 		header("Location: ../projectManagersProject.php");
 	}
?>

<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">
<div id="login-container" class="ui-container">
	<center>
		<form method = "post">
		 <div class="form-group">
		   <label for="projectName">Belongs to Department</label>
		   <select class="custom-select mr-sm-2" name = "relatedDepartmentCreate" id="inlineFormCustomSelect">
		   	<?php

		   	 include "../../../includes/dbconnect.ini.php";

		   	$sqlDepartmentFind = "SELECT departmentId, departmentName FROM Departments";

		   	$stmtDepartmentFind = $conn->query($sqlDepartmentFind);

		   	while ($rowOne = $stmtDepartmentFind->fetch(PDO::FETCH_ASSOC))
		   	{
		   		echo '<option value="'.$rowOne['departmentId'].'">'.$rowOne['departmentName'].'</option>';
		   	}


		  	?>
		  </select>
		   <label for="projectName">Project Name</label>
		   <select class="custom-select mr-sm-2" name = "relatedProjectCreate" id="inlineFormCustomSelect">
		   	<?php

		   	 include "../../../includes/dbconnect.ini.php";

		   	 $sqlProjectFind = "SELECT projectId, projectName FROM Projects WHERE projectManagerId = $tempUserID";

		   	 $stmtProjectFind = $conn->query($sqlProjectFind);

		   	 while ($rowTwo = $stmtProjectFind->fetch(PDO::FETCH_ASSOC))
		   	 {
		   	 	echo '<option value="'.$rowTwo['projectId'].'">'.$rowTwo['projectName'].'</option>';
		   	 }

		   	?>
		   </select>
		   <label class="mr-sm-2" for="inlineFormCustomSelect">Update Status</label>
			<select class="custom-select mr-sm-2" name = "statusChange" id="inlineFormCustomSelect">
			<option selected>Choose...</option>
        	<option value=1> No Progress</option>
        	<option value=2> Early Stages</option>
        	<option value=3> In Progress</option>
        	<option value=4> Almost Finished </option>
        	<option value=5> Finished</option>
      	</select>

      	 <label for = "endDate"> Predicted End Date </label>
		 <input type = "date" class = "form-control" name= "endDateCreate" placeholder = "2019-05-01">





		<button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		<button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>




		</form>
	</center>
</div>