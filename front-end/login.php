<!---------- HTML Section ------------>

<title>login</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="home.html">home</a>
				<a href="login.php">login</a>
				<a href="register.php">register</a>
			</div>
		</div> 
	</div>
	<div id="login-container" class="ui-container">
		<center>
			<form action="login.php" method="post">
				<input class="ui-textfield" type="text" name="username" placeholder="email"><br>
				<input class="ui-textfield" type="password" name="password" placeholder="password"><br>
				<input class="ui-button" type="submit" name ="submit-button" value="Login">
			</form>
			<a href="register.html">register</a>
		</center>
	</div>	

<!---------- PHP Section ------------->
	<?php
	$serverName = "ordinaryserver.database.windows.net";
	$databaseName = "Project_Management_DB";
	$userID = "Eccentricdoggo";
	$password = "Aerodactyl12";

	if (isset($_POST['submit-button']))
	{
		$user = $_REQUEST['username'];
		$passwordEntered = $_REQUEST['password'];

		/* Cutting out the backslashes that a user might've entered into a field */
		$user = stripslashes($user);
		$passwordEntered = stripslashes($passwordEntered);

		try{
		$conn = new PDO( "sqlsrv:server=$serverName;Database = $databaseName", $userID, $password);
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$sql = "SELECT userID FROM Users WHERE email = '$user' AND password = '$passwordEntered'";
		
		$result = $conn->query($sql);

		if ($result->fetchColumn() > 0 ){echo "You've been successfully logged on.";}
		else {echo "Failed to log you in - Invalid username or password";}

		}

		catch(PDOException $e)
	    {echo $sql . "<br>" . $e->getMessage();}

	}

	?>




	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>