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
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="../timesheet/timesheet.php">Timesheet</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div>
	</div>

	<table id="applink-table">
		<tr>
		<td class="applink-td"><a href="../timesheet/timesheet.php" class="applink">Timesheet</a></td>
		<td class="applink-td"><a class="applink" href = "groupManagersTimeApprovals">Timesheet Approvals</a></td>
		<td class="applink-td"><a class="applink" href = "groupManagersTask.php">Tasks</a></td>
		<td class="applink-td"><a class="applink" href = "groupManagersTasksOverview.php"> Tasks Report</a></td>
		<td class="applink-td"><a class="applink" href = "groupManagersEventsView.php">Events</a></td>
		<td class="applink-td"><a class="applink" href = "groupManagersGroupsView.php">Groups</a></td>
		</tr>
	</table>
	<!---
	<a id="applink" href="../timesheets/01262019.html"> Timesheet</a>
	<a id = "applink" href = "groupManagersTimeApprovals"> Timesheet approvals </a>
	<a id="applink" href = "groupManagersTask.php"> Tasks </a>
	<a id = "applink" href = "groupManagersTasksOverview.php"> Tasks Report </a>
	<a id="applink" href = "groupManagersEventsView.php"> Events </a>
	<a id="applink" href = "groupManagersGroupsView.php"> Groups </a>
	<a id ="applink"> Projects</a>
	--->
</body>
</html>
