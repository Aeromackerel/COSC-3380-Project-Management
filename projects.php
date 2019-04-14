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
				<h1>Project Manager Project View</h1>
			</div>
			<div class="summary">
				<img src="logo.jpg" alt="Photo">
				<div>
					<div>
						<p>Project List:</p>
						<table class = "table">
							<thead>
								<tr>
									<th> Project name </th>
									<th> Description </th>
									<th> Status </th>
									<th> Status Notes </th>
									<th> Start Date </th>
									<th> Expected End Date </th>
								</tr>
							</thead>
							<tbody>
								<!----- DB Connection and Query ----->
								<?php
								// Connection to Database
								include "../../includes/dbconnect.ini.php";
								// Query for UserID related to the Event and display the data
								$sqlOne = "SELECT projectName, description, status, startDateTime, endDateTime FROM Projects";
								// Querying and printing to the table
								$stmt = $conn->query($sqlOne);
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{
									echo "<tr><td>".$row['projectName']."</td>
									<td>".$row['description']."</td>
									<td>".$row['status']."</td>
									<td>".$row['startDateTime']."</td>
									<td>".$row['endDateTime']."</td>
									</tr>"
									;
								}
								?>
								<tr>
									<td><?php echo $row['projectName']; ?> </td>
									<td><?php echo $row['description']; ?> </td>
									<td><?php echo $row['status']; ?> </td>
									<td><?php echo $row['startDateTime'];?> </td>
									<td><?php echo $row['endDateTime']; ?> </td>
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
						<li><a id='applink'>Create Project</a></li>
						<li></li>
					</ul>
				</div>

			</div>
		</div>
	</body>
	</html>
