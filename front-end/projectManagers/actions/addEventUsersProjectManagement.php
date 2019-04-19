<!----- PHP HEADER ----->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}

// Store session

$tempUserID = (int)$_SESSION['userID'];
$roleID = (int)$_SESSION['roleID'];

include "../../../includes/dbconnect.ini.php";

$eventID = (int)$_GET['edit'];
$showAlert = (int)$_GET['alert'];
// if Buttons are pressed

if (isset($_POST['goBack']))
{header("Location: ../projectpManagersEvents.php");}


// if Buttons is pressed then we'll add a user to the given event
if (isset($_POST['submitChanges']))
{
	$employeeId = (int)$_POST['relatedEventCreate'];
	try{
	$sqlInsert = "INSERT INTO EventsUsers(eventId, employeeId) VALUES ($eventID, $employeeId)";

	$stmt = $conn->query($sqlInsert);

	header("Location: ../projectManagersEvents.php");
	}
	catch (Exception $e){

		header("Location: addEventUsersProjectManagement.php?edit=$eventID&alert=1");
	}
}







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
		 	<label class="mr-sm-2" for="inlineFormCustomSelect">Employee email</label>
			<select class="custom-select mr-sm-2" name = "relatedEventCreate" id="inlineFormCustomSelect">
				<?php

				//Include DB connection file
				include "../../../includes/dbconnect.ini.php";

				// Query for all groups that the group Manager manages

				$sqlQueryEmployees = "SELECT DISTINCT projectId FROM ProjectUsers WHERE employeeId = $tempUserID";

				$stmt = $conn->query($sqlQueryEmployees);

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					// Query for EmployeeIds

					$sqlQueryEmployeeIds = "SELECT DISTINCT employeeId FROM ProjectUsers WHERE projectId = $row[projectId]";

					$stmt2 = $conn->query($sqlQueryEmployeeIds);

					while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
					{

						$sqlQueryFindEmployeeEmails = "SELECT employeeId,email FROM Employees WHERE employeeId = $row2[employeeId]";

						$stmt3 = $conn->query($sqlQueryFindEmployeeEmails);

						while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
						{
							unset($employeeId, $employeeEmail);
							$employeeId = $row3[employeeId];
							$employeeEmail = $row3['email'];
							echo "echo '<option value=".$employeeId.'">'.$employeeEmail.'</option>';
						}

					}

				}



				?>
			</select>

			<button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 	<button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>



		</div>
	</form>

	<div id="alert" <?php if ($showAlert==0){echo 'style="display:none;"';}else{echo 'style="color:red;"';}	?>>
		This employee is already invited to this event.
	</div>
</center>

	</div>

	</body>


</HTML>
