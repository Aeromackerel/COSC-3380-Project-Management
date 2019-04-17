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
				while($i<4){
					echo"<tr>";
					$mon=rand(0,10)/10;
					$tue=rand(0,10)/10;
					$wed=rand(0,10)/10;
					$thu=rand(0,10)/10;
					$fri=rand(0,10)/10;
					$sat=rand(0,10)/10;
					$sun=rand(0,10)/10;
					echo"<td>proj ".$i."</td>";
					echo"<td>".$mon."</td>";
					echo"<td>".$tue."</td>";
					echo"<td>".$wed."</td>";
					echo"<td>".$thu."</td>";
					echo"<td>".$fri."</td>";
					echo"<td>".$sat."</td>";
					echo"<td>".$sun."</td>";
					echo"<td>".($mon+$tue+$wed+$thu+$fri+$sat+$sun)."</td>";
					echo"</tr>";
					$i++;
				}
			?>
		</table> 
	</div>
</body>
