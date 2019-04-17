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
				<a href="timesheet/01262019.html">Timesheet</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<table id="applink-table">
		<tr>
		<td class="applink-td"><a href="../timesheets/01262019.html" class="applink">Timesheet</a></td>
		<td class="applink-td"><a class="applink"> Employees Report </a> </td>
		<td class="applink-td"><a class= "applink"> Project costs Report </a> </td>
		<td class="applink-td"><a class= "applink"> Project hours Report </a> </td>
		</tr>

		<tr>
		<td class="applink-td"><a class="applink" href = "usersTaskView.php">Tasks</a></td>
		<td class="applink-td"><a class="applink" href = "usersEventsView.php">Events</a></td>
		<td class="applink-td"><a class="applink" href = "usersGroupsView.php">Groups</a></td>
		<td class="applink-td"><a class="applink"> Employees </a> </td>
		</tr>
	</table>
</body>
</html>