<!---------- HTML Section ------------>

<title>Login</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body background= "images/initialBG.jpg">
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="home.php">Home</a>
				<a href="login.php">Login</a>
				<a href="register.php">Register</a>
			</div>
		</div> 
	</div>
	<div id="login-container" class="ui-container">
		<center>
			<form action="login.php" method="post">
				<input class="ui-textfield" type="text" name="username" placeholder="Email"><br>
				<input class="ui-textfield" type="password" name="password" placeholder="Password"><br>
				<input class="ui-button" type="submit" name ="submit-button" value="Login">
			</br>
			</form>
			<a href="register.php">Register</a>
		</br>
			<a href="account.html">Forgot password</a>
		</center>
	</div>	
</body>


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

		$sql = "SELECT userID FROM Users WHERE email = ? AND password = ?";
		
		$result = $conn->prepare($sql);
		$result->execute(array($user, $passwordEntered));

		// Temporary variable to hold the userID - couldn't find a better way to hold this (Bad logic, I know)

		$temp = $result->fetchColumn();

		if ($temp > 0)
		{
			session_start();
			$_SESSION['loggedin'] = true;
			$_SESSION['userID'] = $temp;

			// Querying for role from Employees Table

			$sqlTwo = "SELECT role FROM Employees WHERE employeeId = $temp";

			$stmt = $conn->query($sqlTwo);
			$userRoleRow = $stmt->fetch();
			$userRole = $userRoleRow['role'];

			// Store User's access level, so they could only access pages that is explicitly allowed to them

			$_SESSION['roleID'] = $userRole;

			// Redirects user to user page (for employees)
			if ($userRole == 1)
			{header("Location: /users/userIndex.php");}

			// Redirects group managers to index for group Managers

			else if ($userRole == 2)
			{header ("Location: /groupManagers/groupManagersIndex.php");}

			// Redirects project Managers to index for project Managers

			else if ($userRole == 3)
			{header ("Location: /projectManagers/projectManagersIndex.php");}
			

		}

		else {echo "Failed to log you in - Invalid username or password";}

		}

		catch(PDOException $e)
	    {echo $sql . "<br>" . $e->getMessage();}
	    //if pw coorect
	    //$_SESSION["username"]=sql.get user name

	    //log out

	}

	?>


	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>