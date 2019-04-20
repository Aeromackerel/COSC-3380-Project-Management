<!-- PHP Section ---->
<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.
	if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
	{header ("Location: ../../login.php");}
	$tempUserID = (int)$_SESSION['userID'];
	// Include DB connection
 	include "../../../includes/dbconnect.ini.php";


 	if(isset($_POST['goBack']))
 	{header ("Location: ../projectManagersGroups.php");}

 	else if (isset($_POST['submitChanges']))
 	{


 		header ("Location: ../projectManagersGroups.php");

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
		<label> Group Name </label>
		<input type="text" class="form-control" name ="groupCreate" placeholder="Group Name">
		<br>
		<label class="mr-sm-2" for="inlineFormCustomSelect">Belongs to Project</label>
		<select class="custom-select mr-sm-2" name = "relatedProjectCreate" id="inlineFormCustomSelect">
		<?php

		include "../../../includes/dbconnect.ini.php";

		// Query for projects that a projectManager Runs

		$sqlProjectFind = "SELECT projectId, projectName FROM Projects WHERE projectManagerId = $tempUserID";

		$stmtProjectFind = $conn->query($sqlProjectFind);

		while ($rowProjectFind = $stmtProjectFind->fetch(PDO::FETCH_ASSOC))
		{
			echo "<option value =".$rowProjectFind[projectId].">".$rowProjectFind['projectName']."</option>";
		}
		?>
		</select>
      	 <button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 <button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>
	</form>

	</center>
	</div>
</div>




</HTML>