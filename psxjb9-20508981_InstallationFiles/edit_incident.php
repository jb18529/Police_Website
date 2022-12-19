<?php
    session_start();
    //get the incident form column values and assign them to variables then in
    //dropdown menu go to value='<?php echo $name (then close php quote)' for example
    if(!(isset($_SESSION['log'])))
	{
		header('Location: login.php');
		exit();
	}
    if(isset($_SESSION['I_ID'])){
        require("config.php");
        $conn = new mysqli($servername, $username, $password, $dbname);
        $I_ID = $_SESSION['I_ID'];
        $sql1 = "SELECT * FROM Incident WHERE Incident_ID = '$I_ID';";
        $result1 = mysqli_query($conn, $sql1);
        while($row1 = mysqli_fetch_assoc($result1))
        {
            $personID = $row1['People_ID'];
            $vehicleID = $row1['Vehicle_ID'];
            $incidentReport = $row1['Incident_Report'];
            $dateIncident = $row1['Incident_Date'];
            $offenceIncident = $row1['Offence_ID'];
        }
        //$update = true;
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
            
        </style>
    </head>

    <body>
        <main>
            <h1>Edit Incident Report</h1>
            <form method="POST" action="edit_incident.php" name="editIncident">
                <br><label style="width:500px; text-align:center;">When Using the Dropdown menu make sure to click on the selected choice before submitting.</label>
                <br><br><label>Select a Person</label>
                <br>
                <?php
                    //Dropdown menu for People
                    //Get the value from POST name of the select findout what post returns
                    require("config.php");
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $sql2 = "SELECT * FROM People;";
                    $all_people = mysqli_query($conn, $sql2);
                    echo "<select name=person value=''>Person</option>"; // list box select command
                    while($row2 = mysqli_fetch_assoc($all_people)){//Array or records stored in $row
                        if($row2['People_ID'] == $personID)
                        {
                            echo "<option selected value=".$row2['People_ID'].">".$row2['People_name']." ".$row2['People_address']." ".$row2['People_licence']."</option>";
                        }
                        else 
                        {
                            echo "<option value=".$row2['People_ID'].">".$row2['People_name']." ".$row2['People_address']." ".$row2['People_licence']."</option>"; 
                        }
                        /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br>
                <label>Select a Vehicle</label>
                <br>
                <?php
                    //Dropdown menu for Vehicles
                    $sql3 = "SELECT * FROM Vehicle;";
                    $all_vehicle = mysqli_query($conn, $sql3);
                    echo "<select name=vehicle value=''>Vehicle</option>"; // list box select command
                    while($row3 = mysqli_fetch_assoc($all_vehicle)){//Array or records stored in $row
                        if($row3['Vehicle_ID'] == $vehicleID)
                        {
                            echo "<option selected value=".$row3['Vehicle_ID'].">".$row3['Vehicle_type']." ".$row3['Vehicle_colour']." ".$row3['Vehicle_licence']."</option>"; 
                        }
                        else
                        {    
                            echo "<option value=".$row3['Vehicle_ID'].">".$row3['Vehicle_type']." ".$row3['Vehicle_colour']." ".$row3['Vehicle_licence']."</option>"; 
                        }
                    /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br>
                <label style="text-align:center; width: 250px;" for="Incident_Report">Incident Report (Max length 200 Characters):</label><br>
                <!-- <input type="text" name="Incident_Report" size="50" maxlength="50" required><br> -->
                <textarea id="Incident_Report" name="report" rows="4" cols="80" maxlength="200" value=''><?php echo $incidentReport; ?></textarea>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <br><label style="width:200px; text-align:center;">Incident Date (Enter YYYY-MM-DD form):</label> 
                    <input type="text" pattern="[0-9\-]+" name="date" value="<?php echo $dateIncident; ?>"><br/>
                </div>
                <?php
                    //Dropdown menu for Vehicles
                    $sql4 = "SELECT * FROM Offence;";
                    $all_offences = mysqli_query($conn, $sql4);
                    echo "<select name=offences value=".$offenceIncident.">Offences</option>"; // list box select command
                    while($row4 = mysqli_fetch_assoc($all_offences)){//Array or records stored in $row
                        if($row4['Offence_ID'] == $offenceIncident)
                        {
                            echo "<option selected value=".$row4['Offence_ID'].">".$row4['Offence_description']."</option>";
                        }
                        else
                        {
                            echo "<option value=".$row4['Offence_ID'].">".$row4['Offence_description']."</option>"; 
                        }
                        /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br><button onclick="submitForm()" type="submit" value="submit" name="submit">Edit</button>
                <br><br><label style="text-align: center;">If you need to add a person first:</label>
                <br><a href="add_person.php">Add Person</a>
                <br><br><label style="text-align: center;">If you need to add a vehicle and/or person first:</label>
                <br><a href="add_vehicle.php">Add Vehicle</a>
                <br><br><a href="edit_incident.php">Reload Page</a>
            </form>
            <br>
            <script>
                function submitForm() 
                {
                    if ((editIncident.person.value != null && editIncident.person.value != "") && (editIncident.vehicle.value != null && editIncident.vehicle.value != "") && (editIncident.report.value != null && editIncident.report.value != "") && (editIncident.date.value != null && editIncident.date.value != "") && (editIncident.offences.value != null && editIncident.offences.value != "")) {
                        alert("Are you sure you want to edit?");    
                        return(true);
                    } 
                }
            </script>
            <footer style="text-align:center;"><a href="welcome.php">Back to home page</a></footer>
            <?php  
                
                require("config.php");
                $conn = new mysqli($servername, $username, $password, $dbname);
                

                if(isset($_POST['submit']))
                {
                    //checking if all five inputs are set
                    echo "Success"; 
                      
                    $i_vehicle = $_POST['vehicle'];
                    echo $i_vehicle;
                    $i_person = $_POST['person'];
                    echo $i_person;
                    $i_date = $_POST['date'];
                    echo $i_date;
                    $i_report = $_POST['report'];
                    echo $i_report;
                    $i_offence = $_POST['offences'];
                    echo $i_offence;

                    echo "<br>".$I_ID."<br>";

                    $sql5 = "UPDATE Incident SET Vehicle_ID='$i_vehicle', People_ID='$i_person', Incident_Date='$i_date', Incident_Report='$i_report', Offence_ID='$i_offence' WHERE Incident_ID='$I_ID'";
                    echo "<br><br>sql5=".$sql5."<br/>"; //test
                    //mysqli_query($conn, $sql5);
                    $result5 = mysqli_query($conn, $sql5);

                    
                }
                else
                {
                    echo "<script>alert('You haven't changed anything!');</script>";
                }

                // if(isset($_POST['submit']))
                // {
                //     //checking if all five inputs are set
                //     if(isset($_POST['person']) && isset($_POST['vehicle']) && isset($_POST['report']) && $_POST['report']!= "" && isset($_POST['date']) && isset($_POST['offences'])) 
                //     {
                //         $sql4 = "INSERT INTO Incident(Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES('".$_POST['vehicle']."','".$_POST['person']."','".$_POST['date']."','".$_POST['report']."','".$_POST['offences']."');";
                //         $result4 = mysqli_query($conn, $sql4);
                //         //echo "sql4=".$sql4."<br/>"; //test
                //     }
                // }

                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>