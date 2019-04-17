<!----- PHP Section - Checking if logged in ----->

<?php

session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2)
{header ("Location: ../login.php");}

// Temp variable to hold $userID

$tempUserID = $_SESSION['userID'];

?>

<title> Events Overview </title>
<link rel = "stylesheet" href = "../users/bootstrap.css">
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

  <!----- Inline form to assign employee's new tasks ----->
	<form class = "form-inline" method = post>
		<label class = "sr-only" for = "inlineFormInputName2"> eventName </label>
		<input type = "text" name = "eventNameCreate" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "Event Name">

		<label class = "sr-only" for = "inlineFormInputName2"> Description </label>
		<input type="text" name = "descriptionCreate" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Description">

    <label class = "sr-only" for = "inlineFormInputName2"> Location </label>
		<input type = "text" name = "locationCreate" class = "form-control mb-2 mr-sm-2" id = "inlineFormInputName2" placeholder = "Location">

		<label class = "sr-only" for = "inlineFormInputName2"> Start Date (YYYY-MM-DD) </label>
		<input type = "text" name = "startDateCreate" class = "form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder = "2019-05-01">

    <label class = "sr-only" for = "inlineFormInputName2"> End Date (YYYY-MM-DD) </label>
		<input type = "text" name = "endDateCreate" class = "form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder = "2019-05-01">


            <button type = "submit" class = "btn btn-primary nam" name = "submit-button"> Add Task </button>
	</form>


	<!----- PHP section to ADD a new Task ----->
	<?php
	if (isset($_POST['submit-button']))
	{

	// Connection to the DB

	include "../../includes/dbconnect.ini.php";

	// Using form data to create the entity in the table

	$eventName = $_POST['eventNameCreate'];
  $location = $_POST['locationCreate'];
	$endDate = $_POST['endDateCreate'];
  $startDate = $_POST['startDateCreate'];
	$description = $_POST['descriptionCreate'];

	$sqlCreateQuery = "INSERT INTO Events(eventName, startDateTime, endDateTime, locationEvent, descriptionEvent, deleteFlagStatus)
	VALUES('$eventName', '$startDate', $endDate, '$location', '$description', 0)";

	$stmt=$conn->query($sqlCreateQuery);

	}


	?>

	<table class = "table">
	<thead>
			<tr>
				<th> Event Name</th>
				<th> Description </th>
				<th> Location </th>
				<th> Start Date</th>
				<th> End Date</th>
			</tr>
		</thead>
		<tbody>

		<!----- DB Connection and Query ----->
		<?php

		// Connection to Database

		include "../../includes/dbconnect.ini.php";

		// Query for UserID related to the Event and display the data
		$sqlOne = "SELECT eventName, descriptionEvent, locationEvent, startDateTime, endDateTime FROM Events LEFT JOIN EventsUsers ON EventsUsers.eventId = Events.eventId WHERE EventsUsers.employeeId = $tempUserID ORDER BY startDateTime";


		// Querying and printing to the table

		$stmt = $conn->query($sqlOne);

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr><td>".$row['eventName']."</td>
				<td>".$row['descriptionEvent']."</td>
				<td>".$row['locationEvent']."</td>
				<td>".$row['startDateTime']."</td>
				<td>".$row['endDateTime']."</td>
				</tr>"
				;
		}


		?>

	<!------ Table of Query Results ------>

		<tr>
			<td><?php echo $row['eventName']; ?> </td>
			<td><?php echo $row['description']; ?> </td>
			<td><?php echo $row['location']; ?> </td>
			<td><?php echo $row['startDateTime'];?> </td>
			<td><?php echo $row['endDateTime'];?> </td>
		</tr>
		</tbody>
	</table>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
