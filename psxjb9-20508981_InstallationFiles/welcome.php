<?php 
	session_start();
	
	if(!(isset($_SESSION['log'])))
	{
		header('Location: login.php');
		exit();
	}
	
?>
<html>
	<head>
		<title>Table of Contents</title>
		
	</head>
	<body>	
		<main>
			<h1 style="text-align:center; font-size: 35px;">Table of Contents</h1>
			<ul style="text-align:left; list-style:none; margin-left: 500px;">
				<br>
				<li style="font-size: 25px"><a href="people_search.php">People</a> Search for People</li>
				<br>
				<li style="font-size: 25px"><a href="vehicle_search.php">Vehicle</a> Search for Vehicles</li>
				<br>
				<li style="font-size: 25px"><a href="add_vehicle.php">Add Vehicle</a></li>
				<br>
				<li style="font-size: 25px"><a href="add_person.php">Add Person</a></li>
				<br>
				<li style="font-size: 25px"><a href="incident.php">File Incident Form</a> Enter a New Incident</li>
				<br>
				<li style="font-size: 25px"><a href="search_incident.php"> Search Incident Reports</a> Search for Incident Reports</li>
				<br>
				<li style="font-size: 25px"><a href="edit_incident.php"> Edit Incident Reports</a> Edit Incident Reports</li>
				<br>
				<?php if($uname == "daniels") { ?>
					
					<li style="font-size: 25px"><a href="create_accounts.php"> Create Accounts</a> Create New Police Office Accounts</li>
					<br>
					<li style="font-size: 25px"><a href="add_fines.php"> Add Fines</a> Add New Fines</li>
					<br>
				<?php } ?>
				
			</ul>
			<?php
				if(isset($_SESSION['log']))
				{
				$uname = $_SESSION['log'];
					echo "<footer style=\"text-align:center; font-size: 15px;\">Successfuly logged in as: ".$uname."</footer";
				}
				else
				{
					echo "failure";
					header('Location: login.php');
					exit();
				}
			?>	
			<hr/>
			<hr>
			<h1 style="text-align:center; font-size: 20px;">Admin</h1>
			<ul style="text-align:center; list-style:none; ">
				<li style="font-size: 18px"><a href="change_password.php">Change Password</a> Change Your Password</li>
				<li style="font-size: 18px"><a href="logout.php">Logout</a> Logout</li>
				
			</ul>	

		</main>
	</body>	

</html>
