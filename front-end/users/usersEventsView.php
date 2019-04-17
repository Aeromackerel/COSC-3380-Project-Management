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
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="userIndex.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<center>
	<form method = "post">
		<div class = "form-row align-items-center">
		<input type="text" class="form-control2" name ="eventFind" placeholder="Search for Event">
 		<button type = "submit" name = "searchEvent" class="btn btn-info">search</button>
 	</div>
 	</form>
 </center>

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

		$searchBool = false;

		if (isset($_POST['searchEvent']))
		{$searchBool = true;}


		// If the search bar is looked pressed 

		if($searchBool == true)
		{
			$sqlTwo = "SELECT eventName, descriptionEvent, locationEvent, startDateTime, endDateTime FROM Events LEFT JOIN EventsUsers ON EventsUsers.eventId = Events.eventId WHERE EventsUsers.employeeId = $tempUserID AND eventName LIKE '%$_POST[eventFind]%'";

			$stmt2 = $conn->query($sqlTwo);
			while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr><td>".$row2['eventName']."</td>
					<td>".$row2['descriptionEvent']."</td>
					<td>".$row2['locationEvent']."</td>
					<td>".$row2['startDateTime']."</td>
					<td>".$row2['endDateTime']."</td>
					</tr>";
			}
		}




		else{
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
					</tr>";
			}
		}

		?>

	<!------ Table of Query Results ------>
		</tbody>
	</table>

</body>