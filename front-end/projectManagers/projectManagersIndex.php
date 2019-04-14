<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3) 
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
				<a href="timesheet/01262019.html">timesheet</a>
				<a href="../actionLogOut.php">sign out</a>
			</div>
		</div> 
	</div>
	<a id="applink" href="timesheet/01262019.html"> Timesheet</a>
	<a id = "applink"> Projects </a>
	<a id="applink" href = "usersTaskView.php"> Project Costs Reports </a>
	<a id="applink" href = "usersEventsView.php"> Overview of Project Employees </a>
	<a id="applink" href = "usersGroupsView.php"> Groups </a>
	<a id="applink"> Assign Groups </a>
	<a id="applink"> Assign Events </a>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
</html>