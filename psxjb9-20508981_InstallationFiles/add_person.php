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
        <title>Add New Person</title>
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
            
        </style>
    </head>

    <body>
        <main>
            <h1>Add New Person</h1>
            <form  method="POST" action="add_person.php"  name="addPerson" style="width: 570px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Full Name:</label> 
                    <input type="text" name="fullname"><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Address:</label> 
                    <input type="text" name="address"><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Licence (Max 16 Characters):</label> 
                    <input type="text" name="driverlicence" maxlength="16"><br/>
                </div>
                <button onclick="submitForm()" type="submit" name="search" value="Search">Submit</button> <!-- value is what is submitted to server onclick="return submitform();"-->
                <br><br><label style="text-align:center; width: 250px;">Click link below to file a new incident report after adding a new vehicle:</label>
                <br><br><a href="incident.php">Incident Report</a>
            </form>
            <script>
                function submitForm() 
                {
                    if ((addPerson.fullname.value != null && addPerson.fullname.value != "") && (addPerson.address.value != null && addPerson.address.value != "") && (addPerson.driverlicence.value != null && addPerson.driverlicence.value != "")) {
                        //alert("Form is okay!");
                        
                        
                        //return(false);
                    } 
                    else {
                        alert("You haven't entered a value!");
                        //return (true);
                    }
                }

            </script>
            <footer style="text-align:center;"><a href="welcome.php">Back to home page</a></footer>
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

                //Will add person into People table
                if ((isset($_POST['fullname']) && $_POST['fullname'] != "") && (isset($_POST['address']) && $_POST['address'] != "") && (isset($_POST['driverlicence']) && $_POST['driverlicence'] != "")) 
                {
             

                    $sql1 = "INSERT INTO People(People_name, People_address, People_licence) VALUES ('".$_POST['fullname']."','".$_POST['address']."','".$_POST['driverlicence']."');"; 
                    //echo "sql1=".$sql1."<br/>"; //print out insert statement
                    $result1 = mysqli_query($conn, $sql1);

                    // Will only execute if user has added a vehicle in add_vehicle.php page
                    if(isset($_SESSION['licence'])){
                        $sql2 = "SELECT Vehicle_ID FROM Vehicle WHERE Vehicle_licence = '".$_SESSION['licence']."';";
                        $result2 = mysqli_query($conn, $sql2);
                        while($row2 = mysqli_fetch_assoc($result2)) {
                            $_SESSION['vID'] = $row2["Vehicle_ID"]; 
                        }
                        //Get People_ID for newly added person
                        $sql3 = "SELECT People_ID FROM People WHERE People_licence = '".$_POST['driverlicence']."';";
                        $result3 = mysqli_query($conn, $sql3);
                        while($row2 = mysqli_fetch_assoc($result3)) {
                            $_SESSION['p_ID'] = $row2["People_ID"]; 
                        }
                        $p_id = $_SESSION['p_ID'];
                        $v_ID = $_SESSION['vID'];
                        $sql4 = "INSERT INTO Ownership(People_ID, Vehicle_ID) VALUES ('$p_id','$v_ID');";
                        // send query to database
                        //echo "sql3=".$sql3."<br/>";
                        $result4 = mysqli_query($conn, $sql4);

                        unset($_SESSION['licence']); //reset it 
                        unset($_SESSION['vID']);

                        //exit();
                    }
        
                }                                                         

                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>