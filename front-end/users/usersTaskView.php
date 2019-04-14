<!----- PHP Section ----->

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

	<!---- Inline form for changes ---->
	<form class = "form-inline">
		<div class = "form-group">
			<label for = "taskId"> taskId </label>
			<input type = "taskId" class = form-control id = "taskIdChange">
		</div>
	</form>






	<table class = "table">
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
<script> $(".table").dataTable(); </script>


	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>

<HTML>