<?php

session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

?>

<title> Events Overview </title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
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
		include "../../includes/dbconnect.ini.php";

		// Query for UserID related to the Event and display the data
		$sqlOne = "SELECT eventName, description, location, startDateTime, endDateTime FROM Events LEFT JOIN eventUsers ON eventUsers.eventId = events.eventId WHERE eventUsers.userId = $userIDloggedIN";

		try
			{
				$stmt = $conn->prepare($sqlOne);
				$result = $stmt->execute();
			}

			catch(PDOException $ex)
			{echo "Failed to run query". $ex->getMessage();}

			while ($row = $result->fetch(PDO::FETCH_ASSOC))

		?>

	<!------ Table of Query Results ------>

		<tr>
			<td><?php echo $row['eventName']; ?> </td>
			<td><?php echo $row['description']; ?> </td>
			<td><?php echo $row['location']; ?> </td>
			<td><?php echo $row['startDateTime'];?> </td>
			<td><?php echo $row['enDateTime'];?> </td>
		</tr>
		</tbody>
	</table>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>