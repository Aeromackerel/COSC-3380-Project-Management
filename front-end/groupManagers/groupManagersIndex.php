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
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div>
	</div>

	<table id="applink-table">
		<tr>
		<td class="applink-td" style="height:250px;"><a href="../timesheets/timesheet.php" class="applink">Timesheet</a></td>
		<td class="applink-td" style="height:250px;"><a class="applink" href = "groupManagersTask.php">Individual Tasks</a></td>
		<td class="applink-td" style="height:250px;"><a class="applink" href = "groupManagersTasksOverview.php"> Group Tasks Overview</a></td>
		<td class="applink-td" style="height:250px;"><a class="applink" href = "groupManagersEventsView.php">Events</a></td>
		<td class="applink-td" style="height:250px;"><a class="applink" href = "groupManagersGroupsView.php">Groups</a></td>
		</tr>
	</table>
</body>
</html>