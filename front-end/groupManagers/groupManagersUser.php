<?php
session_start();

// Redirects user to the log in page if they aren't logged in and if they don't have groupManagers privileges

if (!$_SESSION['loggedin'] || $_SESSION['roleID'] != 2) 
{header ("Location: ../login.php");}

$tempUserID = $_SESSION['userID'];

// Connection to DB

include "../../includes/dbconnect.ini.php";

// QUERY FOR Users within a DB

$sqlQueryUsers = "SELECT * FROM Employees";

$stmt = $conn->query($sqlQueryUsers);

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo $row['employeeId'];
	echo "<br>";
}


?>