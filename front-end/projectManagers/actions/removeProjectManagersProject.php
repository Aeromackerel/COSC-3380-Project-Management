<!---- Initial PHP ----->

<?php
	session_start();

	// If user isn't logged in then they will be redirected back to the log in page.
	if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 3)
	{header ("Location: ../../login.php");}

	$tempUserID = (int)$_SESSION['userID'];

	// Include DB connection

 	include "../../../includes/dbconnect.ini.php";

?>

<!---- HTML Section ---->
<!DOCTYPE HTML>
<link rel = "stylesheet" href = "../../bootstrap.css">
<link rel="stylesheet"type="text/css"href="../../style.css">



<div id="login-container" class="ui-container">
	<center>
		<form method = "post">


		</form>
	</center>
</div>