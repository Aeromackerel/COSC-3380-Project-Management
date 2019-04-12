<?php
session_start();

// Use  the session to keep track of the user's ID

$_SESSION['userID'] = $userIDloggedIN;

?>



<!DOCTYPE HTML>

<title> Groups Overview </title>
<link rel="stylesheet"type="text/css"href="../style.css">
<body>
<table>
		<thead>
			<tr>
				<th> Group Member's ID</th>
				<th> Group Member's Email</th>
				<th> Group Member's Phone Number</th>
				<th> Manager </th>
			</tr>
		</thead>
		<tbody>


		<!------ DB Connection and Querying for table ------>

		<?php
		include "../../includes/dbconnect.ini.php";

		// Query for all groupmembers within a group and check for their


		?>






	<div id="footer" class="ui-container">
		<p>footer link</p>
		<p>footer link</p>
		<p>footer link</p>
	</div>
</body>
</HTML>