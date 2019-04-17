<!---- PHP Section ---->
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
 		$eventName = $_POST['eventNameCreate'];
 		$description = $_POST['descriptionCreate'];
    $location = $_POST['locationCreate'];
    $startDate = $_POST['startDateCreate'];
 		$endDate =  $_POST['endDateCreate'];

 		$fieldsFilled = true;

 		// If the fields are empty

 		if (empty($eventName) || empty($description) || empty(location) || empty($endDate) || empty($startDate))
 			{$fieldsFilled = false;}

 		if ($fieldsFilled == true)
 		{
      $sqlCreateEvent = "INSERT INTO Events(eventName, startDateTime, endDateTime, locationEvent, descriptionEvent, deleteFlagStatus)
  	VALUES('$eventName', '$startDate', $endDate, '$location', '$description', 0)";

 		$stmt = $conn->query($sqlCreateEvent);

 		header ("Location: ../groupManagersEventsView.php");
 		}
 	}

 	else if (isset($_POST['goBack']))
 	{header ("Location: ../groupManagersEventsView.php");}



?>




<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">



<div id="login-container" class="ui-container">
	<center>
		<form method = "post">
		 <div class="form-group">
		   <label for="Event Name">Event Name</label>
		   <input type="text" class="form-control" name ="eventNameCreate" placeholder="Event Name">

		   <label for = "Description"> Description </label>
		   <input type = "text" class = "form-control" name = "descriptionCreate" placeholder = "Description">

		   <label for = "Location"> Location </label>
		   <input type = "text" class = "form-control" name = "locationCreate" placeholder = "Houston Office">

       <label for = "startDate"> Start Date </label>
		   <input type = "date" class = "form-control" name= "startDateCreate" placeholder = "2019-05-01">

       <label for = "endDate"> End Date </label>
		   <input type = "date" class = "form-control" name= "endDateCreate" placeholder = "2019-05-01">

      	 <button type="submit" name = "goBack" class="btn btn-secondary btn-space2">Back</button>
		 <button type="submit" name = "submitChanges" class="btn btn-primary btn-space2">Submit</button>
	</form>

	</center>
</div>




</HTML>
