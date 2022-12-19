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
        <title>Search Incident Reports</title>
        <link rel="stylesheet" href="style1.css">
        <style>   
            table, td {
                padding: 0.3rem;
                border: 1px solid black;
                border-collapse: collapse;
                text-align: left;
                background-color: #FFB74C; 
                color: #451ECC;
                font-family: Tahoma, Arial, Helvetica, sans-serif;
            }
            th {
                padding: 0.3rem;
                background-color: #CC6E1E; 
                color: #FFB74C; 
            }
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
            <h1 style="font-weight: bold; color: blue; background-color:grey;">Search Incident Reports</h1>
            <form  method="POST" action="search_incident.php"  name="searchIncidents" style="width: 570px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Enter Driving Licence Number (Max 16 characters):</label> 
                    <input type="text" name="drivingLicence" maxlength="16"><br/>
                </div>
                <label></label>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Enter Vehicle Plate Number:</label> 
                    <input type="text" name="vehiclePlate"><br/>
                </div>
                <button onclick="submitForm()" type="submit" name="submit" value="Search">Search</button> <!-- value is what is submitted to server onclick="return submitform();"-->
            </form>
            <script>
                function submitForm() {
                    if ((searchIncidents.drivingLicence.value != null && searchIncidents.drivingLicence.value != "") || (searchIncidents.vehiclePlate.value != null && searchIncidents.vehiclePlate.value != "")) {
                        //alert("Form is okay!");
                           
                        //return(false);
                    } 
                    else {
                        alert("You haven't entered a value in at least on field!");
                        //return (true);
                    }
                }
                function confirmIncident(Incident_ID) 
                {
                    var conf = confirm("Are you sure?"); 
                    if (conf == true) // if OK pressed
                    {
                        selectParam="?selecting="+Incident_ID; // add del parameter to URL
                        alert('Will take you to edit page');
                        this.document.location.href=selectParam; // reload document goes through PHP again
                    }
                } 
            </script>
            <footer style="text-align:center;"><a href="welcome.php" style="color:white;">Back to home page</a></footer>
            <?php  
                require("config.php");
                //session_start()
                //if (isset($_POST['Search']))
                //echo "Success";
                if (isset($_GET['selecting']) && $_GET['selecting']!="")
                {
                    
                    $_SESSION['I_ID'] = $_GET['selecting'];
                    header('Location: edit_incident.php');
                    exit();
                }
                if (isset($_POST['submit'])){

                
                    if ((isset($_POST['drivingLicence']) && $_POST['drivingLicence'] != "")) 
                    {
                        //echo "drivingPOST";
                        $conn = new mysqli($servername, $username, $password, $dbname);
               
                        // first sql People to find People_ID of name then search incident form and display

                        $drivingLicence = $_POST['drivingLicence'];
                        $sql1 = "SELECT * FROM People WHERE People_licence = '$drivingLicence';";
                        $result1 = mysqli_query($conn, $sql1);
                        while($row1 = mysqli_fetch_assoc($result1)){
                            $pID = $row1['People_ID'];
                        }
                        
                        $sql2 = "SELECT * FROM Incident WHERE People_ID = '$pID';";
                        $result2 = mysqli_query($conn, $sql2);

                        

                        if (mysqli_num_rows($result2) > 0) 
                        {
                            echo "<br><table style=\"margin-left: auto; margin-right: auto;\">";  // start table
                            echo "<tr><th>Vehicle ID</th><th>Date</th><th>Report</th><th>Offence ID</th><th>Edit</th></tr>"; // table header
                        
                        // loop through each row of the result (each tuple will  
                        // be contained in the associative array $row)
                            while($row2 = mysqli_fetch_assoc($result2)) 
                            {
                                //echo var_dump($row1);
                                echo "<tr>";
                                echo "<td>".$row2["Vehicle_ID"]."</td>";
                                echo "<td>".$row2["Incident_Date"]."</td>"; 
                                echo "<td>".$row2["Incident_Report"]."</td>";
                                echo "<td>".$row2["Offence_ID"]."</td>";
                                echo "<td><button onclick=confirmIncident(".$row2["Incident_ID"].")>Edit</button></td>";
                                echo "</tr>";
                            } 
                            echo "</table>"; 
                        }
                        else 
                        {
                            echo "<script>alert('Incident Not Found for this Person!');</script>";
                            //echo "Query not found!";
                        } 
                            
                        
                    } 
                    if ((isset($_POST['vehiclePlate']) && $_POST['vehiclePlate'] != "")) 
                    {
                        //echo "vehiclePOST";
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // first sql People to find People_ID of name then search incident form and display

                        $vehiclePlate = $_POST['vehiclePlate'];
                        $sql1 = "SELECT * FROM Vehicle WHERE Vehicle_licence = '$vehiclePlate';";
                        $result1 = mysqli_query($conn, $sql1);
                        while($row1 = mysqli_fetch_assoc($result1)){
                            $vehicleID = $row1['Vehicle_ID'];
                        }
                        
                        $sql2 = "SELECT * FROM Incident WHERE Vehicle_ID = '$vehicleID';";
                        //echo "sql2 = ".$sql2."<br>";
                        $result2 = mysqli_query($conn, $sql2);

                        

                        if (mysqli_num_rows($result2) > 0) 
                        {
                            echo "<br><br><br><table>";  // start table
                            echo "<tr><th>People ID</th><th>Date</th><th>Report</th><th>Offence ID</th><th>Edit</th></tr>"; // table header
                        
                        // loop through each row of the result (each tuple will  
                        // be contained in the associative array $row)
                            while($row2 = mysqli_fetch_assoc($result2)) 
                            {
                                //echo var_dump($row1);
                                echo "<tr>";
                                echo "<td>".$row2["People_ID"]."</td>";
                                echo "<td>".$row2["Incident_Date"]."</td>"; 
                                echo "<td>".$row2["Incident_Report"]."</td>";
                                echo "<td>".$row2["Offence_ID"]."</td>;";
                                echo "<td><button onclick=confirmIncident(".$row2["Incident_ID"].")>Edit</button></td>";
                                //echo "<button onclick=confirmPerson(".$row1["People_ID"].")>Add Person</button></td>";
                                echo "</tr>";
                            } 
                            echo "</table>"; 
                        }
                        else 
                        {
                            echo "<script>alert('Incident Not Found for this Vehicle!');</script>";
                            //echo "Query not found!";
                        } 
                    }
                    else
                    {
                        //echo "<script>alert('Incident Not Found for this entry!');</script>";
                    }

                }                                                     
                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>
