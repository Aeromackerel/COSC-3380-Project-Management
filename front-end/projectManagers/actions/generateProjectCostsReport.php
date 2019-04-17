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
<title>Project Costs Report</title>
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

	<center> <label> Total Budget </label> </center>

	<center> <label> Maintainence Costs </label> </center>

	<center> <label> Total Costs </label> </center>

	</div>

</body>
</HTML>