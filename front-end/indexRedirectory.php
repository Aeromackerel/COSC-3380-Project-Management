<?php
session_start();

$roleLevel = $_SESSION['roleID'];

// General redirectory file depending on the user's access level - See SQL DB Lookup Tables on why

if ($roleLevel == 1)
	{header("Location: /users/userIndex.php");}

else if ($roleLevel == 2)
	{header ("Location: /groupManagers/groupManagersIndex.php");}

else if ($roleLevel == 3)
	{header ("Location: /projectManagers/projectManagersIndex.php");}

?>