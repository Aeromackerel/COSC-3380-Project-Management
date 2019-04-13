<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin']) 
{header ("Location: ../login.php");}



?>

<!---- HTML Section ---->

<!DOCTYPE HTML>
<title>dashboard</title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">menu</button>
		   <div class="nav-links">
				<a href="timesheet/01262019.html">timesheet</a>
				<a href="../actionLogOut.php">sign out</a>
			</div>
		</div> 
	</div>
	<a id="applink" href="timesheet/01262019.html">timesheet</a>
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