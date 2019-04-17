<!---- PHP SECTION ---->

<?php
session_start();
if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
{header ("Location: ../login.php");}
?>

<!---- HTML Section ---->

<!DOCTYPE HTML>
<title>Dashboard</title>
<link rel="stylesheet"type="text/css"href="../users/bootstrap.css">
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
		<td class="applink-td" style="height:250px"><a href="../timesheets/timesheet.php" class="applink">Timesheet</a></td>
		<td class="applink-td" style="height:250px"><a href = "projectManagersEmployeeReport.php" class="applink"> Employees Report </a> </td>
		<td class="applink-td" style="height:250px"><a href = "projectManagersCostReport.php" class= "applink"> Project costs Report </a> </td>
		<td class="applink-td" style="height:250px"><a href = "projectManagersHoursReport.php" class= "applink"> Project hours Report </a> </td>
		</tr>

		<tr>
		<td class="applink-td" style="height:250px"><a class="applink" href = "projectManagersTasks.php"> Tasks </a></td>
		<td class="applink-td" style="height:250px"><a class="applink" href = "projectManagersEvents.php"> Events </a></td>
		<td class="applink-td" style="height:250px"><a class="applink" href = "projectManagersGroups.php"> Groups </a></td>
		<td class="applink-td" style="height:250px"><a class="applink" href = "projectManagersEmployees.php"> Employees </a></td>
		</tr>
	</table>
</body>
</html>
