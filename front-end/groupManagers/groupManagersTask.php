<?php

// start session and check if the roleId is == 2

session_start();

// Redirects user to the log in page if they aren't logged in and if they don't have groupManagers privileges

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];


?>

<!----- HTML SECTION ----->
<DOCTYPE HTML>
<link rel = "stylesheet" href = "../users/bootstrap.css">
<title> Tasks Overview </title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="groupManagersIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>

	<!---- Inline form for changes ---->
	<form class = "form-inline" method = post>
		<label class = "sr-only" for = "inlineFormInputName2"> taskId </label>
		<input type = "text" name = "taskIdChange" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "taskId # goes here">

		<label class = "sr-only" for = "inlineFormInputName2"> Status notes change </label>
		<input type="text" name = "statusNotesChange" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Status notes change">

		<label class="mr-sm-2" for="inlineFormCustomSelect">Update Status</label>
		<select class="custom-select mr-sm-2" name = "statusChange" id="inlineFormCustomSelect">
			<option selected>Choose...</option>
        	<option value=1> 1 - Have not started</option>
        	<option value=2> 2 - Stuck</option>
        	<option value=3> 3 - In Progress</option>
        	<option value=4> 4 - Almost Finished </option>
        	<option value=5> 5 - Finished</option>
      </select>

     <div class="form-check mb-2 mr-sm-2">
    <input class="form-check-input" name = "flagForDeletion" type="checkbox" id="inlineFormCheck">
    <label class="form-check-label" for="inlineFormCheck">
    	Flag for Deletion
    </label>
	</div>

      <button type = "submit" class = "btn btn-primary nam" name = "submit-button"> Submit changes </button>
	</form>

	<!----- If button is pressed, we want to make changes to the task table ----->

	<?php
		
	// Connection to the DB

	include "../../includes/dbconnect.ini.php";

	// Setting default date time zone to America for startDateTime update
	date_default_timezone_get('America');

	// Storing variables from the given form to update the DB and if button is pressed change the information within the DB

	if (isset($_POST['submit-button']))
	{
	$taskIdRef = $_POST['taskIdChange'];
	$statusNotes = $_POST['statusNotesChange'];
	$statusId = $_POST['statusChange'];

	// Query if the status was 1 before

	$sqlStartDateQuery = "SELECT status FROM TASKS WHERE taskId = '$taskIdRef'";
	$stmt = $conn->prepare($sqlStartDateQuery);
	$stmt->execute();
	$sqlStartDateRow = $stmt->fetch(PDO::FETCH_ASSOC);
	$sqlStartDateBoolean = false;

	if ($sqlStartDateRow['status'] == 1)
	{
		$sqlStartDateBoolean = true;
		$sqlStartDate = date("Y-m-d H:i:s"); 
	}

	// If the flag for deletion has been inserted then we'll push the notice to the DB admin to check if we should delete or not

	if (isset($_POST['flagForDeletion']))
	{
		$flagDelete = $_POST['flagForDeletion'];
		$sqlOneFlag = "UPDATE TASKS SET statusNotes = '$statusNotes', status = '$statusId', deleteFlagStatus = 1 WHERE taskId = '$taskIdRef'";
		$stmt = $conn->prepare($sqlOneFlag);
		$stmt->execute();
	}

	// Otherwise we just perform an update Query

	else
	{
		$sqlOne = "UPDATE TASKS SET statusNotes = '$statusNotes', status = '$statusId' WHERE taskId = '$taskIdRef'";
		$stmt = $conn->prepare($sqlOne);
		$stmt->execute();

		// Update the start time

		if ($sqlStartDateBoolean == true)
		{
			$sqlOneStart = "UPDATE Tasks SET startDate = '$sqlStartDate'";
			$stmt = $conn->prepare($sqlOneStart);
			$stmt->execute();
		}
	}



	}

	?>

	<table id = "tasksTable" class = "table">
		<thead>
			<tr>
				<th> Task ID </th>
				<th> Task name </th>
				<th> Description </th>
				<th> Status </th>
				<th> Status Notes </th>
				<th> Start Date </th>
				<th> Expected End Date </th>
			</tr>
		</thead>
		<tbody>


			<!------ DB connection and Query ------->

			<?php

			// Connection to the DB

			include "../../includes/dbconnect.ini.php";

			// Query for userID with the session email that we have from the session

			$sqlOne = "SELECT taskId, taskName, description, status, statusNotes, startDate, desiredEndDateTime FROM Tasks WHERE employeeId = $tempUserID";

			// Prints to the table so what they have

			$stmt = $conn->query($sqlOne);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr><td>".$row['taskId']."</td>
				<td>".$row['taskName']."</td>
				<td>".$row['description']."</td>
				<td>".$row['status']."</td>
				<td>".$row['statusNotes']."</td>
				<td>".$row['startDate']."</td>
				<td>".$row['desiredEndDateTime']."</td>
				</tr>"
				;

			}


			?>
		</tbody>
	</table>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type = "text/javascript">
$(document).ready(function()
{$(".tasksTable").dataTable();
}); 
</script>



</body>
	
</HTML>
