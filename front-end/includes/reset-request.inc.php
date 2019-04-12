<?php

if (isset($_POST["reset-button"]))
{
$selector = bin2hex(random_bytes(8));

// Used to authenticate the user

$token = random_bytes(32);

// Come back and fill this later with Azure server name and make sure you have the token in it too!

$url = "www.localhost:8000/forgottenpwd/create-new-password.php?selector".selector. "&validator=" .bin2hex($token);

$expires = date("U") + 600;

// Database connection

$serverName = "ordinaryserver.database.windows.net";
$databaseName = "Project_Management_DB";
$userID = "Eccentricdoggo";
$password = "Aerodactyl12";

// Retrieves user's email

$userEmail = $_POST["email"];

// Prepared statement

$sql = "DELETE FROM passwordReset WHERE pwdResetEmail=?";



}

else
{
header("Location: ../index.html");
}


?>