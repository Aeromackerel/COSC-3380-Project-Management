<?php
session_start();

// Use  the session to keep track of the user's ID

$_SESSION['userID'] = $userIDloggedIN;

?>



<!DOCTYPE HTML>

<title> Tasks Overview </title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<table>
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
			include "../../includes/dbconnect.ini.php";

			// Query for userID with the session email that we're given
			$sqlOne = "SELECT taskName, description, status, statusNotes, startDate, desiredEndDateTime FROM Tasks WHERE employeeID = '$userIDloggedIN'";

			try
			{
				$stmt = $conn->prepare($sqlOne);
				$result = $stmt->execute();
			}

			catch(PDOException $ex)
			{echo "Failed to run query". $ex->getMessage();}

			while ($row = $result->fetch(PDO::FETCH_ASSOC))

			?>
		<tr>
			<td><?php echo $row['taskName']; ?> </td>
			<td><?php echo $row['description']; ?> </td>
			<td><?php echo $row['status']; ?> </td>
			<td><?php echo $row['statusNotes'];?> </td>
			<td><?php echo $row['startDate'];?> </td>
			<td><?php echo $row['desiredEndDateTime'];?> </td>
		</tr>
		</tbody>
	</table>




	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>

<HTML>