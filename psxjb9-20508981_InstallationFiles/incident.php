<?php
    session_start();
    if(!(isset($_SESSION['log'])))
	{
		header('Location: login.php');
		exit();
	}
?>
<DOCTYPE! html>
<html>
    <head>
        <title>File a New Incident</title>
        <link rel="stylesheet" href="style1.css">
        <style>   
            table, td {
                padding: 0.3rem;
                border: 1px solid black;
                border-collapse: collapse;
                text-align: left;
                background-color: #FFB74C; 
                color: #451ECC;
                font-family: Tahoma, Arial, Helvetica, sans-serif;}
            th {
                padding: 0.3rem;
                background-color: #CC6E1E; 
                color: #FFB74C; }
            h1 {
                font-family: Charcoal, sans-serif;
                color: #451ECC; } 
       
            p {
                font-family: Arial, Helvetica, sans-serif;
                color: #451ECC;} 
            body {
                background-image: url('images/main_background.jpg');
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
            <h1 style="font-weight: bold; color: blue; background-color:grey;">New Incident Report</h1>
            <form method="POST" action="incident.php" name="newIncident">
                <br><label style="width:500px; text-align:center;">When Using the Dropdown menu make sure to click on the selected choice before submitting.</label>
                <br><br><label>Select a Person</label>
                <br>
                
                <?php
                    //Dropdown menu for People
                    //Get the value from POST name of the select findout what post returns
                    require("config.php");
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $sql1 = "SELECT * FROM People;";
                    $all_people = mysqli_query($conn, $sql1);
                    echo "<select name=person value='person'>Person</option>"; // list box select command
                    while($row1 = mysqli_fetch_assoc($all_people)){//Array or records stored in $row
                        echo "<option value=".$row1['People_ID'].">".$row1['People_name']." ".$row1['People_address']." ".$row1['People_licence']."</option>"; 
                    /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br>
                <label>Select a Vehicle</label>
                <br>
                <?php
                    //Dropdown menu for Vehicles
                    $sql2 = "SELECT * FROM Vehicle;";
                    $all_vehicle = mysqli_query($conn, $sql2);
                    echo "<select name=vehicle value=''>Vehicle</option>"; // list box select command
                    while($row2 = mysqli_fetch_assoc($all_vehicle)){//Array or records stored in $row
                        echo "<option value=".$row2['Vehicle_ID'].">".$row2['Vehicle_type']." ".$row2['Vehicle_colour']." ".$row2['Vehicle_licence']."</option>"; 
                    /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br>
                <label style="text-align:center; width: 250px;" for="Incident_Report">Incident Report (Max length 200 Characters):</label><br>
                <!-- <input type="text" name="Incident_Report" size="50" maxlength="50" required><br> -->
                <textarea id="Incident_Report" name="report" rows="4" cols="80" maxlength="200"></textarea>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <br><label style="width:200px; text-align:center;">Incident Date (Enter YYYY-MM-DD form):</label> 
                    <input type="text" pattern="[0-9\-]+" name="date"><br/>
                </div>
                <?php
                    //Dropdown menu for Vehicles
                    $sql3 = "SELECT * FROM Offence;";
                    $all_offences = mysqli_query($conn, $sql3);
                    echo "<select name=offences value=''>Offences</option>"; // list box select command
                    while($row3 = mysqli_fetch_assoc($all_offences)){//Array or records stored in $row
                        echo "<option value=".$row3['Offence_ID'].">".$row3['Offence_description']."</option>"; 
                    /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br><button onclick="submitForm()" type="submit" value="submit" name="submit">Submit</button>
                <br><br><label style="text-align: center;">If you need to add a person first:</label>
                <br><a href="add_person.php">Add Person</a>
                <br><br><label style="text-align: center;">If you need to add a vehicle and/or person first:</label>
                <br><a href="add_vehicle.php">Add Vehicle</a>
                <br><br><footer style="text-align:center;"><a href="welcome.php" style="color:black;">Back to home page</a></footer>
            </form>
            
            <br>
            <script>
                function submitForm() 
                {
                    if ((newIncident.person.value != null && newIncident.person.value != "") && (newIncident.vehicle.value != null && newIncident.vehicle.value != "") && (newIncident.report.value != null && newIncident.report.value != "") && (newIncident.date.value != null && newIncident.date.value != "") && (newIncident.offences.value != null && newIncident.offences.value != "")) {
                        //alert("Form is okay!");    
                        //return(false);
                    } 
                    else {
                        alert("You haven't entered a value!");
                        //return (true);
                    }
                }
            </script>
            
            <?php  
                require("config.php");
                $conn = new mysqli($servername, $username, $password, $dbname);
                //testing
                // if (isset($_POST['submit'])) {
                //     //both return the ID so People_ID and Vehicle_ID
                //     echo "option1=".$_POST['person']."<br/>"; 
                //     echo "option2=".$_POST['vehicle']."<br/>";
                //     echo "option3=".$_POST['report']."<br/>";
                //     echo "option4=".$_POST['date']."<br/>";
                //     echo "option5=".$_POST['offences']."<br/>";
                //     //echo "option1=".$_POST['person']."<br/>";
                // }

                if(isset($_POST['submit']))
                {
                    //checking if all five inputs are set
                    if(isset($_POST['person']) && isset($_POST['vehicle']) && isset($_POST['report']) && $_POST['report']!= "" && isset($_POST['date']) && isset($_POST['offences'])) 
                    {
                        $sql4 = "INSERT INTO Incident(Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES('".$_POST['vehicle']."','".$_POST['person']."','".$_POST['date']."','".$_POST['report']."','".$_POST['offences']."');";
                        $result4 = mysqli_query($conn, $sql4);
                        //echo "sql4=".$sql4."<br/>"; //test
                    }
                }

                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>