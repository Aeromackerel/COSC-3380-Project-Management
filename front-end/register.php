<!------ HTML SECTION ------>

<!DOCTYPE HTML>
<title>Register</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
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

	<div id="register-container" class="ui-container">
		<center>
			<form action="register.php" method="post">
				<input class="ui-textfield" type="text" name="fname" placeholder="First name">
				<input class="ui-textfield" type="text" name="lname" placeholder="Last name"><br>
				<input class="ui-textfield" type="text" name="email" placeholder="Email"><br>
				<input class="ui-textfield" type="text" name="phonenumber" placeholder="Phone-number"><br>
				<input class="ui-textfield" type="password" name="password0" placeholder="Password"><br>
				<input class="ui-textfield" type="password" name="password1" placeholder="Re-enter Password"><br>
				<input class="ui-button" type="submit" name = "submit-button" value="Register">
			</form>
			<a href="login.html">Login</a>
		</center>
	</div>	


	<!----- Form input into MS SQL ---->
	<?php
	$serverName = "ordinaryserver.database.windows.net";
	$databaseName = "Project_Management_DB";
	$userID = "Eccentricdoggo";
	$password = "Aerodactyl12";

	if (isset($_POST['submit-button']))
	{
		$firstName = $_POST['fname'];
		$lastName = $_POST['lname'];
		$email = $_POST['email'];
		$phoneNumber = $_POST['phonenumber'];
		$passwordOne = $_POST['password0'];
		$passwordTwo = $_POST['password1'];


		/* Strips the backspaces just in case if the user entered any backspaces */
		$firstName = stripslashes($firstName);
		$lastName = stripslashes($lastName);
		$email = stripslashes($email);
		$phoneNumber = stripslashes($phoneNumber);
		$passwordOne = stripslashes($passwordOne);
		$passwordTwo = stripslashes($passwordTwo);

		try{
		$conn = new PDO( "sqlsrv:server=$serverName;Database = $databaseName", $userID, $password);
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


		if ($passwordOne == $passwordTwo){
		$sql = "INSERT INTO Employees (firstName, lastName, email, phonenumber, role)
		VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', 1)";
		$conn->exec($sql);
		$user_insert_ID = $conn->lastInsertId();

		$sql2 = "INSERT INTO Users (userID, email, password)
		VALUES ('$user_insert_ID','$email', '$passwordOne')";
		$conn->exec($sql2);
		}

		else 
		{
			echo "Wrong password";
		}

		}

		catch(PDOException $e)
	    {echo $sql . "<br>" . $e->getMessage();}

	}



	$conn = null;
	?>

	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>

</html>

