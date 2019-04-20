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
 			   <th>Sun</th>
			   <th>Mon</th>
			   <th>Tue</th>
			   <th>Wed</th>
			   <th>Thu</th>
			   <th>Fri</th>
			   <th>Sat</th>
			   <th>Total Hours</th>
			</tr>
			<?php

			session_start();

			$tempUserID = (int)$_SESSION['userID'];

			// Array to hold ID
			$projectIdArray = array();


			// Include DB connection
			include "../../includes/dbconnect.ini.php";

			//get day for reference
			$day = date('D');
			$dayArray = array(0 => "Sun", 1 => "Mon", 2 => "Tue", 3=> "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat");

			$dateIndex = array_search($day, $dayArray);
			echo $dateIndex;
			// So if user tries to update their hours then we'll update their timesheet
			if (isset($_POST['update-button']))
			{
				$sqlFindprojectId2 = "SELECT projectId FROM Timesheet WHERE employeeId = $tempUserID";

				$stmtPID = $conn->query($sqlFindprojectId2);

				while($rowPID = $stmtPID->fetch(PDO::FETCH_ASSOC))
				{array_push($projectIdArray, $rowPID['projectId']);}

				foreach($projectIdArray as $value)
				{
					$hours = $_POST["".$day.$value];
					// UPDATE QUERY

					$sqlUpdateHours = "UPDATE Timesheet SET hours=$hours WHERE projectId = $value AND employeeId = $tempUserID AND day = $dayIndex";

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

			// Query for Timesheet data
			$sqlFindHours = "SELECT Timesheet.hours as hours, DATEPART(weekday, Timesheet.date) AS weekday, Projects.projectName AS pName FROM Timesheet LEFT JOIN Projects ON Timesheet.projectId=Projects.projectId WHERE Timesheet.projectId = $i AND Timesheet.employeeId = $tempUserID AND DATEPART(week, Timesheet.date)=DATEPART(week, GETDATE())";

			$stmtFindHours = $conn->query($sqlFindHours);

			$sunHours = 0;//$rowhours['daySeven'];
			$monHours = 0;//$rowhours['dayOne'];
			$tueHours = 0;//$rowhours['dayTwo'];
			$wedHours = 0;//$rowhours['dayThree'];
			$thuHours = 0;//$rowhours['dayFour'];
			$friHours = 0;//$rowhours['dayFive'];
			$satHours = 0;//$rowhours['daySix'];


			while ($rowhours = $stmtFindHours->fetch(PDO::FETCH_ASSOC)){
				echo"<td>".$rowhours['pName']."</td>";
				echo "<td><input style='width:30%;' type='text' name='Sun".$i."' value='";
				if ($rowhours['weekday'] == 1){
					$sunHours = $rowhours['hours'];
					echo "".$sunHours."";
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 0)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Mon".$i."' value='";
				if ($rowhours['weekday'] == 2) {
					$monHours = $rowhours['hours'];
					echo $monHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 1)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Tue".$i."' value='";
				if ($rowhours['weekday'] == 3) {
					$tueHours = $rowhours['hours'];
					echo $tueHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 2)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Wed".$i."' value='";
				if ($rowhours['weekday'] == 4) {
					$wedHours = $rowhours['hours'];
					echo $wedHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 3)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Thu".$i."' value='";
				if ($rowhours['weekday'] == 5) {
					$thuHours = $rowhours['hours'];
					echo $thuHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 4)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Fri".$i."' value='";
				if ($rowhours['weekday'] == 6) {
					$friHours = $rowhours['hours'];
					echo $friHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 5)
					echo " disabled";
				echo"></td>";
				echo "<td><input style='width:30%;' type='text' name='Sat".$i."' value='";
				if ($rowhours['weekday'] == 7) {
					$satHours = $rowhours['hours'];
					echo $satHours;
				}
				else{
					echo "0";
				}
				echo "'";
				if ($dateIndex != 6)
					echo " disabled";
				echo"></td>";

			echo "<td>".($sunHours+$monHours+$tueHours+$wedHours+$thuHours+$friHours+$satHours)."</td>";
			echo "</tr>";
			}
			}
			?>
		</table>
			</br>
			<input class="ui-button" type="submit" name ="update-button"  style="margin-bottom:20px;"value="Update">
		</center>
		</form>
	</div>
</body>
