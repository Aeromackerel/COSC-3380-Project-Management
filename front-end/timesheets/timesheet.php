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
			$hoursArray = array(0 => $sunHours, 1 => $monHours, 2 => $tueHours, 3 => $wedHours, 4 => $thuHours, 5 => $friHours, 6 => $satHours);
			$disableArray = array();

			$projName = "";

			foreach ($hoursArray as $key => $value) {
				if ($key == $dateIndex){
					$disableArray[$key] = "";
				}
				else{
					$disableArray[$key] = "disabled";
				}
			}

			while ($rowhours = $stmtFindHours->fetch(PDO::FETCH_ASSOC)){
				$hoursArray[$rowhours['weekday']-1] = $rowhours['hours'];
				$projName = $rowhours['pName'];
			}

			echo"<td>".$projName."</td>";
			echo "<td><input style='width:30%;' type='text' name='Sun".$i."' value='".$hoursArray[0]."' ".$disableArray[0]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Mon".$i."' value='".$hoursArray[1]."' ".$disableArray[1]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Tue".$i."' value='".$hoursArray[2]."' ".$disableArray[2]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Wed".$i."' value='".$hoursArray[3]."' ".$disableArray[3]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Thu".$i."' value='".$hoursArray[4]."' ".$disableArray[4]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Fri".$i."' value='".$hoursArray[5]."' ".$disableArray[5]."></td>";
			echo "<td><input style='width:30%;' type='text' name='Sat".$i."' value='".$hoursArray[6]."' ".$disableArray[6]."></td>";

			echo "<td>".array_sum($hoursArray)."</td>";
			echo "</tr>";
			}

			?>
		</table>
			</br>
			<input class="ui-button" type="submit" name ="update-button"  style="margin-bottom:20px;"value="Update">
		</center>
		</form>
	</div>
</body>
