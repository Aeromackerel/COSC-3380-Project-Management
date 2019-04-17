<!---- PHP SECTION ---->

<?php
session_start();

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

?>


<!DOCTYPE HTML>
<title>Project Costs Report</title>
<link rel="stylesheet"type="text/css"href="../users/bootstrap.css">
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="projectManagersIndex.php"> Back to Index </a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<div id = "login-container" class = "ui-container">
		<center><p> Employee Report </p></center>
	</div>
</body>
<HTML>