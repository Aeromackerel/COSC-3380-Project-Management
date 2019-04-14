<!----- PHP Section - Checking if logged in ----->

<?php
session_start();
// If user isn't logged in then they will be redirected back to the log in page.
if (!$_SESSION['loggedin'])
{header ("Location: ../login.php");}
// Temp variable to hold $userID
$tempUserID = $_SESSION['userID'];
?>



<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Projects</title>
	<link href="styles.css" rel="stylesheet">
</head>

<body>
	<header>
		<div id='signIn'>
			<a href="">sign-in</a>
		</div>
	</header>
	<div class="content">
		<div class="main-content">
			<div class="title">
				<h1>Project Manager Group View</h1>
			</div>
			<div class="summary">
				<img src="logo.jpg" alt="Photo">
				<div>
					<div>
						<p>Group List:</p>
						<table class = "table">
							<thead>
								<tr>
									<th> Group name </th>
									<th> Group Manager </th>
									<th> Status </th>
									<th> Notes </th>
								</tr>
							</thead>
							<tbody>
								<!----- DB Connection and Query ----->
								<?php
								// Connection to Database
								include "../../includes/dbconnect.ini.php";
								// Query for UserID related to the Event and display the data
								$sqlOne = "SELECT ";
								// Querying and printing to the table
								$stmt = $conn->query($sqlOne);
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{
									echo "<tr><td>".$row['groupName']."</td>
									<td>".$row['groupManager']."</td>
									<td>".$row['status']."</td>
									<td>".$row['startDateTime']."</td>
									<td>".$row['description']."</td>
									</tr>"
									;
								}
								?>
								<tr>
									<td><?php echo $row['groupName']; ?> </td>
									<td><?php echo $row['groupManager']; ?> </td>
									<td><?php echo $row['status']; ?> </td>
									<td><?php echo $row['startDateTime'];?> </td>
									<td><?php echo $row['description']; ?> </td>
								</tr>
								<!-- maybe make these clickable and bring up reports of some kind-->
							</tbody>
						</table>
					</div>

				</div>



			</div>
			<div class="footer">
				<div>
					<h4>Other Stuff:</h4>
					<ul>
						<li><a id='applink'>Create new Group</a></li>
						<li></li>
					</ul>
				</div>

			</div>
		</div>
	</body>
	</html>
