<!----- PHP Section - Checking if logged in ----->

<?php

session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

// Temp variable to hold $userID

$tempUserID = $_SESSION['userID'];

?>

<title> Events Overview </title>
<link rel = "stylesheet" href = "bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body background = "../images/workBG.jpg">
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="userIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
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
		$sqlOne = "SELECT eventName, descriptionEvent, locationEvent, startDateTime, endDateTime FROM Events LEFT JOIN EventsUsers ON EventsUsers.eventId = Events.eventId WHERE EventsUsers.employeeId = $tempUserID";


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