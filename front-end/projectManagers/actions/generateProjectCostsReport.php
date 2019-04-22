<!----- PHP HEADER ----->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3) 
{header ("Location: ../login.php");}

// Store session

$tempUserID = (int)$_SESSION['userID'];
$roleID = (int)$_SESSION['roleID'];
$projectId = (int)$_GET['report'];
$from = $_GET['from'];
$to = $_GET['to'];
// Include DB Connection
include "../../../includes/dbconnect.ini.php";
//Total Budget
$sqlTotalBudgetQuery = "SELECT totalBudget FROM ProjectCosts";
$stmt1 = $conn->query($sqlTotalBudgetQuery);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$budgetTotal = $row1['totalBudget'];
//Total Costs
//-----current issue is with the sql statement. Just need to add both columns and spit it out`
$sqlTotalCostsQuery = "SELECT tasksCosts + wagesCosts as totalCost From ProjectCosts";
$stmt3 = $conn->query($sqlTotalCostsQuery);
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$costsTotal = $row3['totalCost'];
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

	echo "<center><p> Project Costs Report on $row[projectName] $from to $to </p></center>"

	?>

	<center> <label> Total Budget </label> </center>
	<center>
		<?php 
			echo "<p>".$budgetTotal."</p>";
		?>
	</center>

	<center> <label> Total Costs </label> </center>
	<center>
		<?php 
			echo "<p>".$costsTotal."</p>";
		?>
	</center>
	</div>

</body>
</HTML>