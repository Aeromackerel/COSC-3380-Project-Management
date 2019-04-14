<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin']) 
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
				<a href="../timesheets/01262019.html">Timesheet</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<a id="applink" href="../timesheets/01262019.html">Timesheet</a>
	<a id="applink" href = "usersTaskView.php"> Tasks </a>
	<a id="applink" href = "usersEventsView.php"> Events </a>
	<a id="applink" href = "usersGroupsView.php"> Groups </a>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
</html>