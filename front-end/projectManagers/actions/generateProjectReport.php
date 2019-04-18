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
			$sqlTotalProjectTasksQuery = "SELECT COUNT(taskId) as totalTasks FROM Tasks WHERE projectId = $projectId";
			$stmt2 = $conn->query($sqlTotalProjectTasksQuery);
			$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
			//echo "<p>".$row2['']."</p>";
			echo "<p>".$row2['totalTasks']."</p>";
			?>
		</center>
		<center> <label> Tasks Complete </label> </center>
		<center>
			<?php
			$completeStatus=5;
			$sqlProjectTasksCompletedQuery = "SELECT COUNT(taskId) as completedTasks FROM Tasks WHERE projectId = $projectId AND status = $completeStatus";

			$stmt3 = $conn->query($sqlProjectTasksCompletedQuery);
			$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
			echo "<p>".$row3['completedTasks']."</p>";
			?>
		</center>

		<center> <label> Tasks In Progress </label> </center>
		<center>
			<?php
			$sqlProjectTasksInProgressQuery = "SELECT COUNT(taskId) as progressTasks FROM Tasks WHERE projectId = $projectId AND (status = 2 OR status = 3 OR status = 4)";

			$stmt3 = $conn->query($sqlProjectTasksInProgressQuery);
			$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
			echo "<p>".$row3['progressTasks']."</p>";
			?>
		</center>

		<center> <label> Tasks not started </label> </center>
		<center>
			<?php
			$notStartedStatus=1;
			$sqlProjectTasksCompletedQuery = "SELECT COUNT(taskId) as notStartedTasks FROM Tasks WHERE projectId = $projectId AND status = $notStartedStatus";

			$stmt3 = $conn->query($sqlProjectTasksCompletedQuery);
			$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
			echo "<p>".$row3['notStartedTasks']."</p>";
			?>
		</center>

	</div>

</body>
</HTML>
