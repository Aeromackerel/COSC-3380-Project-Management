<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2) 
{header ("Location: ../login.php");}



?>

<!---- HTML Section ---->

<!DOCTYPE HTML>
<title>Dashboard</title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body background= "../images/workBG.jpg">
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="../timesheets/01262019.html">timesheet</a>
				<a href="../actionLogOut.php">sign out</a>
			</div>
		</div> 
	</div>
	<a id="applink" href="../timesheets/01262019.html"> Timesheet</a>
	<a id = "applink" href = "groupManagersTimeApprovals"> Timesheet approvals </a>
	<a id="applink" href = "groupManagersTask.php"> Tasks </a>
	<a id = "applink" href = "groupManagersTasksOverview.php"> Tasks Report </a>
	<a id="applink" href = "groupManagersEventsView.php"> Events </a>
	<a id="applink" href = "groupManagersGroupsView.php"> Groups </a>
	<a id ="applink"> Projects</a>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
</html>