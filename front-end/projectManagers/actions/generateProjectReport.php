<!----- PHP HEADER ----->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}

// Store session

$tempUserID = (int)$_SESSION['userID'];
$roleID = (int)$_SESSION['roleID'];

$projectId = (int)$_GET['report'];


?>

<!----- HTML SECTION ----->

<!DOCTYPE HTML>
<title>Project Hours Report</title>
<link rel="stylesheet"type="text/css"href="../../users/bootstrap.css">
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

		<?php

		// Include DB Connection

		include "../../../includes/dbconnect.ini.php";

		$sqlProjectNameQuery = "SELECT projectName FROM Projects WHERE projectId = $projectId";

		$stmt = $conn->query($sqlProjectNameQuery);

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<center><p> Project Hours Report on $row[projectName] </p></center>"

		?>

		<center> <label> Total Hours put into Project </label> </center>

		<center> <label> Total Tasks </label> </center>
		<center>
			<?php
			//$sqlProjectTasksQ = "SELECT COUNT(taskId) FROM Tasks WHERE projectId = $projectId";
			$sqlProjectTasksQ = "SELECT COUNT(taskId) as totalTasks FROM Tasks WHERE projectId = $projectId";
			$stmt2 = $conn->query($sqlProjectTasksQ);
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			//echo "<p>".$row2[0]."</p>";
			echo "<p>".$row2['totalTasks']."</p>";
			?>
		</center>
		<center> <label> Tasks Complete </label> </center>

		<center>
			<?php
			$completestatus=0;
			$sqlProjectTasksQ2 = "SELECT * FROM Tasks WHERE projectId = $projectId AND status = $completestatus";

			$stmt3 = $conn->query($sqlProjectTasksQ2);
			$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
			echo "<p>".count($row3)."</p>";
			?>
		</center>
		<center> <label> Tasks In Progress </label> </center>

		<center> <label> Tasks not started </label> </center>

	</div>

</body>
</HTML>
