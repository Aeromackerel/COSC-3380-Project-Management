<!DOCTYPE HTML>
<title> Timesheet </title>
<link rel="stylesheet"type="text/css"href="..\style.css">
<body>
	<div id="header" class="ui-container">
		<div class="nav">
		   <button class="nav-hover">Menu</button>
		   <div class="nav-links">
				<a href="userIndex.php">Back to Index</a>
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
			   <th>Total</th>
			</tr>
			<?php
				$i=0;
				
				while($i<4){   //replace with each row from db
				
					echo"<tr>";
					
					$proj_name="proj".$i; //replace with project name
					
					$mon=rand(0,10)/10;   //replace with hours per day from db
					$tue=rand(0,10)/10;   //  |
					$wed=rand(0,10)/10;   //  |
					$thu=rand(0,10)/10;   //  v
					$fri=rand(0,10)/10;   //
					$sat=rand(0,10)/10;   //
					$sun=rand(0,10)/10;   //
					
					
					
					echo"<td>".$proj_name."</td>";  
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Mon".$i."' value='".$mon."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Tue".$i."' value='".$tue."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Wed".$i."' value='".$wed."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Thu".$i."' value='".$thu."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Fri".$i."' value='".$fri."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Sat".$i."' value='".$sat."'/></td>";
					echo"<td><input style='width:30%;' type='text' name='".$proj_name."Sun".$i."' value='".$sun."'/></td>";
					echo"<td>".($mon+$tue+$wed+$thu+$fri+$sat+$sun)."</td>";
					
					echo"</tr>";
					
					$i++;
				}
			?>
			
		</table>	
			</br>
			<input class="ui-button" type="submit" name ="update-button"  style="margin-bottom:20px;"value="Update">
		</center>
		</form>	
	</div>
</body>
