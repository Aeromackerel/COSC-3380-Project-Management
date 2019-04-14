<!----- PHP Section - Checking if logged in ----->

<?php
session_start();
// If user isn't logged in then they will be redirected back to the log in page.
if (!$_SESSION['loggedin'])
{header ("Location: ../login.php");}
// Temp variable to hold $userID
$tempUserID = $_SESSION['userID'];
?>



<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Events</title>
	<link href="styles.css" rel="stylesheet">
</head>

<body>
	<header>
		<div id='signIn'>
			<a href="">sign-in</a>
		</div>
	</header>
	<div class="content">
		<div class="main-content">
			<div class="title">
				<h1>Project Manager Event View</h1>
			</div>
			<div class="summary">
				<img src="logo.jpg" alt="Photo">
				<div>
					<div>
						<p>Event List:</p>
						<table class = "table">
							<thead>
								<tr>
									<th> Event name </th>
									<th> Description </th>
									<th> Date </th>
									<th> Location </th>
								</tr>
							</thead>
							<tbody>

								<!----- DB Connection and Query ----->
								<?php
								// Connection to Database
								include "../../includes/dbconnect.ini.php";
								// Query for UserID related to the Event and display the data
								$sqlOne = "SELECT eventName, description, location, startDateTime FROM Events LEFT JOIN EventsUsers ON EventsUsers.eventId = Events.eventId WHERE EventsUsers.employeeId = $tempUserID";
								// Querying and printing to the table
								$stmt = $conn->query($sqlOne);
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{
									echo "<tr><td>".$row['eventName']."</td>
									<td>".$row['description']."</td>
									<td>".$row['startDateTime']."</td>
									<td>".$row['location']."</td>
									</tr>"
									;
								}
								?>
								<tr>
									<td><?php echo $row['eventName']; ?> </td>
									<td><?php echo $row['description']; ?> </td>
									<td><?php echo $row['startDateTime'];?> </td>
									<td><?php echo $row['location']; ?> </td>
								</tr>

							</tbody>
						</table>
					</div>

				</div>



			</div>
			<div class="footer">
				<div>
					<h4>Other Stuff:</h4>
					<ul>
						<li><a id = ''>Create New Event<a></li>
						<li>Something Wrong?</li>

					</ul>
				</div>

			</div>
		</div>
	</body>
	</html>
