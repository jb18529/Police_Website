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
		<style>
            body {
            background-image: url('images/welcomepage.jpg');
			background-repeat: no-repeat;
			width: 100%;
			background-size: cover;
			background-position: center;
			position: relative;
			height: 100%; 
            }
        </style> 
	</head>
	<body>	
		<main>
			<h1 style="text-align:center; font-size: 35px; font-weight: bold; color: blue; background-color:grey; margin-left: 70px;">Table of Contents</h1>
			<ul style="text-align:center; list-style:none;  background-color:green; margin-left: 340px; margin-right: 300px;">
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
				<?php if($_SESSION['log'] == "daniels") { ?>
					
					<li style="font-size: 25px"><a href="create_accounts.php"> Create Accounts</a> Create New Police Officer Accounts</li>
					<br>
					<li style="font-size: 25px"><a href="add_fines.php"> Add Fines</a> Add New Fines</li>
					<br>
				<?php } ?>
				
			</ul>
			<?php
				if(isset($_SESSION['log']))
				{
				$uname = $_SESSION['log'];
					echo "<br><footer style=\"text-align:center; font-size: 18px; color:red; font-weight: bold;\">LOGGED IN AS: ".$uname."</footer";
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
