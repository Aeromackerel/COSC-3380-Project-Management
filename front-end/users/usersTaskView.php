<?php
session_start();

// If user isn't logged in then they will be redirected back to the log in page.

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

?>



<!DOCTYPE HTML>
<link rel = "stylesheet" href = "bootstrap.css">
<title> Tasks Overview </title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<table class = "table">
		<thead>
			<tr>
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

			$sqlOne = "SELECT taskName, description, status, statusNotes, startDate, desiredEndDateTime FROM Tasks WHERE employeeId = $tempUserID";

			$stmt = $conn->query($sqlOne);
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				echo "<tr><td>".$row['taskName']."</td>
				<td>".$row['description']."</td>
				<td>".$row['status']."</td>
				<td>".$row['statusNotes']."</td>
				<td>".$row['startDate']."</td>
				<td>".$row['desiredEndDateTime']."</td>"
				;
			}

			// Let's add a button to allow employee's to start a task

			?>
		</tbody>
	</table>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script> $(".table").dataTable(); </script>




	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>

<HTML>