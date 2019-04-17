<!DOCTYPE HTML>
<title> Timesheet </title>
<link rel="stylesheet"type="text/css"href="..\style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="../indexRedirectory.php">Back to Index</a>
				<a href="../actionLogOut.php">Sign out</a>
			</div>
		</div> 
	</div>
	<div id="ui-timesheet">
		<form action="timesheet.php" method="post">
		<center>
	   <table>
		    <tr>
			   <th>Project</th>
			   <th>Mon</th>
			   <th>Tue</th>
			   <th>Wed</th>
			   <th>Thu</th>
			   <th>Fri</th>
			   <th>Sat</th>
			   <th>Sun</th>
			   <th>Total Hours</th>
			</tr>
			<?php

			session_start();

			$tempUserID = (int)$_SESSION['userID'];

			// Array to hold ID
			$projectIdArray = array();


			// Include DB connection

			include "../../includes/dbconnect.ini.php";

			// So if user tries to update their hours then we'll update their timesheet

			if (isset($_POST['update-button']))
			{
				$sqlFindprojectId2 = "SELECT projectId FROM Timesheet WHERE employeeId = $tempUserID";

				$stmtPID = $conn->query($sqlFindprojectId2);

				while($rowPID = $stmtPID->fetch(PDO::FETCH_ASSOC))

				{array_push($projectIdArray, $rowPID['projectId']);}

				foreach($projectIdArray as $value)
				{
					$monHours = $_POST["Mon".$value];
					$tueHours = $_POST["Tue".$value];
					$wedHours = $_POST["Wed".$value];
					$thuHours = $_POST["Thu".$value];
					$friHours = $_POST["Fri".$value];
					$satHours = $_POST["Sat".$value];
					$sunHours = $_POST["Sun".$value];

					// UPDATE QUERY

					$sqlUpdateHours = "UPDATE Timesheet SET dayOne = $monHours, dayTwo = $tueHours, dayThree = $wedHours, dayFour = $thuHours, dayFive = $friHours, daySix = $satHours, daySeven = $sunHours WHERE projectId = $value AND employeeId = $tempUserID";

					$stmtUpdateHours = $conn->query($sqlUpdateHours);

				}

			}





				
			echo"<tr>";

			$sqlFindprojectIds = "SELECT projectId from ProjectUsers WHERE employeeId = $tempUserID";

			$stmtFindpIds = $conn->query($sqlFindprojectIds);

			while ($row = $stmtFindpIds->fetch(PDO::FETCH_ASSOC))
			{


		
			$i = $row['projectId'];

			// Query for projectName

			$sqlFindprojectNames = "SELECT projectName from Projects WHERE projectId = $i";

			$stmtFindpNames = $conn->query($sqlFindprojectNames);

			$rowName = $stmtFindpNames->fetch(PDO::FETCH_ASSOC);

			$proj_name = $rowName['projectName'];

			// Query for Timesheet data

			$sqlFindHours = "SELECT dayOne, dayTwo, dayThree, dayFour, dayFive, daySix, daySeven FROM Timesheet WHERE projectId = $i AND employeeId = $tempUserID";

			$stmtFindHours = $conn->query($sqlFindHours);

			$rowhours = $stmtFindHours->fetch(PDO::FETCH_ASSOC);

			$monHours = $rowhours['dayOne'];
			$tueHours = $rowhours['dayTwo'];
			$wedHours = $rowhours['dayThree'];
			$thuHours = $rowhours['dayFour'];
			$friHours = $rowhours['dayFive'];
			$satHours = $rowhours['daySix'];
			$sunHours = $rowhours['daySeven'];
			
			$mon=$monHours;   //replace with hours per day from db
			$tue=$tueHours;  //  |
			$wed=$wedHours;   //  |
			$thu=$thuHours;   //  v
			$fri=$friHours;  //
			$sat=$satHours;   //
			$sun=$sunHours;   //

			array_push($projectIdArray, $i);					
			
					
			echo"<td>".$proj_name."</td>";  
			echo"<td><input style='width:30%;' type='text' name='Mon".$i."' value='".$mon."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Tue".$i."' value='".$tue."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Wed".$i."' value='".$wed."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Thu".$i."' value='".$thu."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Fri".$i."' value='".$fri."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Sat".$i."' value='".$sat."'/></td>";
			echo"<td><input style='width:30%;' type='text' name='Sun".$i."' value='".$sun."'/></td>";
			echo"<td>".($mon+$tue+$wed+$thu+$fri+$sat+$sun)."</td>";
					
			echo"</tr>";
			
			}


			?>
			
		</table>	
			</br>
			<input class="ui-button" type="submit" name ="update-button"  style="margin-bottom:20px;"value="Update">
		</center>
		</form>	
	</div>
</body>