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

			// Hols user ID

			$tempUserID = (int)$_SESSION['userID'];

			// Array to hold project ID

			$projectIdArray = array();

			// Include DB connection

			include "../../includes/dbconnect.ini.php";

			//get day for reference

			$day = date('D');

			$dayArray = array(0 => "Sun", 1 => "Mon", 2 => "Tue", 3=> "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat");

			$dateIndex = array_search($day, $dayArray);

			$dayIndex = date('Y-m-d');

			// So if user tries to update their hours then we'll update their timesheet

			if (isset($_POST['update-button']))
			{
				$sqlFindprojectId2 = "SELECT projectId FROM ProjectUsers WHERE employeeId = $tempUserID";

				$stmtFindproject2 = $conn->query($sqlFindprojectId2);

				while ($rowFindproject2 = $stmtFindproject2->fetch(PDO::FETCH_ASSOC))
				{
					$hours = (float)$_POST[$day.$rowFindproject2['projectId']];

					$projectId = $rowFindproject2['projectId'];

					$sqlTimeSheet = "UPDATE Timesheet SET hours = $hours WHERE employeeId = $tempUserID AND projectId = $projectId AND date = (select convert(varchar(10),getDate(),120))";

					$conn->query($sqlTimeSheet);



					$sqlTimeSheet = "IF NOT EXISTS (SELECT * FROM Timesheet WHERE employeeId = $tempUserID AND date = (select convert(varchar(10),getDate(),120)) AND projectId = $projectId) INSERT INTO Timesheet(projectId, employeeId, hours, date)
					VALUES($projectId, $tempUserID, $hours, (select convert(varchar(10),getDate(),120)))";

					$conn->query($sqlTimeSheet);
				}

			}

			// Start the table

			echo"<tr>";

			// Query for ProjectId where a user's projects

			$sqlFindprojectIds = "SELECT projectId from ProjectUsers WHERE employeeId = $tempUserID";
			$stmtFindpIds = $conn->query($sqlFindprojectIds);
			while ($row = $stmtFindpIds->fetch(PDO::FETCH_ASSOC))
			{

			// To store the projectId

			$i = $row['projectId'];

		
			//echo 'Sun'.$i;

			// Query for projectName

			$sqlFindprojectNames = "SELECT projectName from Projects WHERE projectId = $i";

			$stmtFindpNames = $conn->query($sqlFindprojectNames);

			$rowName = $stmtFindpNames->fetch(PDO::FETCH_ASSOC);

			$proj_name = $rowName['projectName'];

			echo"<td>".$proj_name."</td>";

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