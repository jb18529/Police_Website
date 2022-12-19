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
        <title>Add Vehicle/Person</title>
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
       
            p, form {
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
            <h1 style="font-weight: bold; color: blue; background-color:grey;">Add Vehicle</h1>
            <form  method="POST" action="add_vehicle.php"  name="addVehicle" style="width: 570px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Vehicle Type:</label> 
                    <input type="text" name="type"><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Vehicle Colour:</label> 
                    <input type="text" name="colour"><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Vehicle Registration Number:</label> 
                    <input type="text" name="licence"><br/>
                </div>
                <label style="text-align:center; width: 300px;">Once Fields Filled in, Click Submit First:</label>
                <br><br><button onclick="submitForm()" type="submit" name="search" value="Search">Submit</button> <!-- value is what is submitted to server onclick="return submitform();"-->
                <br><br><label style="text-align:center; width: 250px; float:left;">Click link below to add a new person to the recently submitted vehicle or choose one from the list below:</label><br><label style="text-align:center; width: 250px; float:right;">Click link below to file a new incident report after adding a new vehicle:</label>
                
                <br><br><br/><br/><a href="add_person.php" style="float:left; margin-left: 60px;">Add New Person</a><a href="incident.php" style="float:right; margin-right: 60px;">Incident Report</a><br>
            
            </form>
            <script>
                function submitForm() 
                {
                    if ((addVehicle.type.value != null && addVehicle.type.value != "") && (addVehicle.colour.value != null && addVehicle.colour.value != "") && (addVehicle.licence.value != null && addVehicle.licence.value != "")) {
                        //alert("Form is okay!");
                        
                        
                        //return(false);
                    } 
                    else {
                        alert("You haven't entered a value!");
                        //return (true);
                    }
                }
                function confirmPerson(People_ID) 
                {
                    var conf = confirm("Are you sure?"); 
                    if (conf == true) // if OK pressed
                    {
                        selectParam="?select="+People_ID; // add del parameter to URL
                        alert('Person Added to Vehicle');
                        this.document.location.href=selectParam; // reload document goes through PHP again
                    }
                } 
            </script>
            <footer style="text-align:center;"><a href="welcome.php" style="color:white;">Back to home page</a></footer>
            <?php  
                require("config.php");
                $conn = new mysqli($servername, $username, $password, $dbname);

                //session_start()
                //if (isset($_POST['Search']))
                //echo "Success";
                if(mysqli_connect_errno()) 
                {
                   echo "Failed to connect to MySQL: ".mysqli_connect_error();
                   die();
                } 

                // $number = $_POST['licence'];
                // $sql4 = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_ID = '$number';";
                // $result4 = mysqli_query($conn, $sql4);
                // echo "result4=".$result4."<br/>";
                // $_SESSION['v_ID'] = $result4;
                if ((isset($_POST['type']) && $_POST['type'] != "") && (isset($_POST['colour']) && $_POST['colour'] != "") && (isset($_POST['licence']) && $_POST['licence'] != "") && ($_GET['select'] == "")) 
                {
                    //echo "Success";
                    //Will insert new vehicle into Vehicle Table
                    $_SESSION['licence'] = $_POST['licence'];   //session licence is vehicle plate number 
                    $licence = $_POST['licence'];
                    $sql1 = "INSERT INTO Vehicle(Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES ('".$_POST['type']."','".$_POST['colour']."','".$_POST['licence']."');"; 
                    //echo "sql1=".$sql1."<br/>"; //print out insert statement
                    $result1 = mysqli_query($conn, $sql1);

                    $sql5 = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_licence = '".$_SESSION['licence']."';";
                    $result5 = mysqli_query($conn, $sql5);
                    while($row3 = mysqli_fetch_assoc($result5)) {
                        $_SESSION['vID'] = $row3["Vehicle_ID"]; 
                    }
                    // store vehicle ID so for incident.php page will insert into ownership table with chosen person

                    //exit();
                    
        
                }                                                         
                //selecting person
                if (isset($_GET['select']) && $_GET['select']!="") //select is the People_ID
                {
                    //echo ".$_POST['licence'].";
                    //echo "<h1>".$_SESSION['v_ID']."<h1>";

                    $sql4 = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_licence = '".$_SESSION['licence']."';";
                    $result4 = mysqli_query($conn, $sql4);
                    while($row2 = mysqli_fetch_assoc($result4)) {
                        $_SESSION['vID'] = $row2["Vehicle_ID"]; 
                    }
                    //echo "session= ".$_SESSION['green']."<br/>";
                    //echo "session= ".$_SESSION['vID']."<br/>";

                    $p_id = $_GET['select'];
                    $vehicleID = $_SESSION['vID'];
                    //$conn = new mysqli($servername, $username, $password, $dbname);
                    //echo "Has entered Get block";
                    $sql3 = "INSERT INTO Ownership(People_ID, Vehicle_ID) VALUES ('$p_id','$vehicleID');";
                    // send query to database
                    //echo "sql3=".$sql3."<br/>";
                    $result3 = mysqli_query($conn, $sql3);
                    //echo "success adding person";
                    unset($_SESSION['vID']);
                    unset($_SESSION['licence']);
                    
                    
                }

                $sql2 = "SELECT * FROM People;"; // show all names, only once
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) 
                {
                    echo "<br><table style=\"margin-left: auto; margin-right: auto;\">";  // start table
                    echo "<tr><th>Name</th><th>Address</th><th>Licence</th><th>Add Person</th></tr>"; // table header
                
                // loop through each row of the result (each tuple will  
                // be contained in the associative array $row)
                    while($row = mysqli_fetch_assoc($result2)) 
                    {
                        //echo var_dump($row1);
                        echo "<tr>";
                        echo "<td>".$row["People_name"]."&nbsp;&nbsp;";
                        echo "<td>".$row["People_address"]."&nbsp;&nbsp;"; 
                        echo "<td>".$row["People_licence"]."</td>"; 
                        echo "<td><button onclick=confirmPerson(".$row["People_ID"].")>Add Person</button></td>";
                        echo "</tr>";
                    } 
                    echo "</table>"; 
                }
                else 
                {
                    echo "<script>alert('Error!');</script>";
                    //echo "Query not found!";
                } 

                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>