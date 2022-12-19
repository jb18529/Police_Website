<?php
    #will need to use join to join Vehicle and People tables and Ownership table
    session_start();
    if(!(isset($_SESSION['log'])))
	{
		header('Location: login.php');
		exit();
	}
?>

<html>
    <head>
        <title>Vehicle Registration Number Search</title>
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
            
        </style>
    </head>

    <body>
        <main>
            <h1>Vehicle Registration/Plate Number Search</h1>
            <form  method="POST" action="vehicle_search.php"  name="searchVehicle" style="width: 570px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Enter Plate Number:</label> 
                    <input type="text" name="number"><br/>
                </div>
                <button onclick="submitForm()" type="submit" name="search" value="Search">Search</button> <!-- value is what is submitted to server onclick="return submitform();"-->
            </form>
            <script>
                function submitForm() {
                    if (searchVehicle.number.value != null && searchVehicle.number.value != "") {
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
                //session_start()
                //if (isset($_POST['Search']))
                //echo "Success";
                if (isset($_POST['number']) && $_POST['number'] != "") 
                {
                    //echo "Success";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if(!$conn) {
                        die ("Connection failed");
                    }
                    else
                    {
                        
                        $number = $_POST['number'];
                        $sql = "SELECT Vehicle_licence, Vehicle_type, Vehicle_colour, People_name, People_licence FROM People
                                LEFT JOIN Ownership ON People.People_ID = Ownership.People_ID
                                LEFT JOIN Vehicle ON Ownership.Vehicle_ID = Vehicle.Vehicle_ID
                                WHERE Vehicle_licence = '$number'
                                UNION
                                SELECT Vehicle_licence, Vehicle_type, Vehicle_colour, People_name, People_licence FROM People
                                RIGHT JOIN Ownership ON People.People_ID = Ownership.People_ID
                                RIGHT JOIN Vehicle ON Ownership.Vehicle_ID = Vehicle.Vehicle_ID
                                WHERE Vehicle_licence = '$number';"; 
                        
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) 
                        {
                            echo "<br><table>";  // start table
                            echo "<tr><th>Registration Number</th><th>Type</th><th>Colour</th><th>Name</th><th>Licence</th></tr>"; // table header
                        
                        // loop through each row of the result (each tuple will  
                        // be contained in the associative array $row)
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                //echo var_dump($row1);
                                echo "<tr>";
                                echo "<td>".$row["Vehicle_licence"]."</td>"; 
                                echo "<td>".$row["Vehicle_type"]."</td>";
                                echo "<td>".$row["Vehicle_colour"]."</td>";
                                echo "<td>".$row["People_name"]."</td>";
                                echo "<td>".$row["People_licence"]."</td>";
                                echo "</tr>";
                            } 
                            echo "</table>"; 
                        }
                        else 
                        {
                            echo "<script>alert('Vehicle Registration Number Not Found!');</script>";
                            //echo "Query not found!";
                        } 
                        
                    }
                }                                                         
                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>