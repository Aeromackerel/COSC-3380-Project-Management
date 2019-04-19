<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.
	if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2)
	{header ("Location: ../../login.php");}

	$tempUserID = (int)$_SESSION['userID'];

	// Include DB connection

 	include "../../../includes/dbconnect.ini.php";

 	// If button is pressed then we'll generate the task

 	if (isset($_POST['submitChanges']))
 	{
 		$employeeId = $_POST['relatedEmployeeCreate'];
 		$groupId = $_POST['relatedGroupCreate'];

 		$fieldsFilled = true;

 		if (empty($groupId) || empty($employeeId))
 		{$fieldsFilled = false;}



 		if ($fieldsFilled == true)
 		{
 			$sqlAddGroup = "INSERT INTO GroupsUsers(employeeId, groupId) VALUES ($employeeId, $groupId)";
 			header ("Location: ../groupManagersGroupsView.php");
 		}

 	}
 	else if (isset($_POST['goBack']))
 	{header ("Location: ../groupManagersGroupsView.php");}
?>




<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../../users/bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">



<div id="login-container" class="ui-container">
	<center>
		<form method = "post">
		<div class="form-group">

		<label class="mr-sm-2" for="inlineFormCustomSelect">Assign Employee</label>
		<select class="custom-select mr-sm-2" name = "relatedEmployeeCreate" id="inlineFormCustomSelect">

		<?php

		// Including DB connection file

		include "../../../includes/dbconnect.ini.php";

		$sqlEmployees = "SELECT firstName, lastName, employeeId FROM Employees";

		$stmt = $conn->query($sqlEmployees);

		while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '<option value="'.$row['employeeId'].'">'.$row['firstName']." ".$row['lastName'].'</option>';
		}

		?>

		</select>

		<label class="mr-sm-2" for="inlineFormCustomSelect">Assign to Group</label>
		<select class="custom-select mr-sm-2" name = "relatedGroupCreate" id="inlineFormCustomSelect">

		<?php

		include "../../../includes/dbconnect.ini.php";

		$sqlGroupIds = "SELECT groupId FROM GroupsUsers WHERE employeeId = $tempUserID";

		$stmtTwo = $conn->query($sqlGroupIds);

		while ($rowTwo = $stmtTwo->fetch(PDO::FETCH_ASSOC))
		{
			$sqlGroups = "SELECT groupId, groupName FROM Groups WHERE groupId = $rowTwo[groupId]";

			$stmtThree = $conn->query($sqlGroups);

			while ($rowThree = $stmtThree->fetch(PDO::FETCH_ASSOC))
			{
				echo '<option value="'.$rowThree['groupId'].'">'.$rowThree['groupName'].'</option>';
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