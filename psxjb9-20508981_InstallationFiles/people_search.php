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
        <title>Database Search People</title>
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
        <h1 style="font-weight: bold; color: blue; background-color:grey;">Database Search People</h1>
        <!-- <h2><u>People database</u></h2> -->
        <form  method="POST" action="people_search.php"  name="searchPeople" style="width: 550px;" >
            <div class="form-element" style="color: black; font-size: 3.0rem;">
                <label style="font-size: 1.5rem;"><nobr>Name/License Search</nobr></label> 
            </div>
            <div class="form-element" style="color: black;">
                <label >Name: </label> 
                <input type="text" name="name"><br/>
            </div>
            <div class="form-element" style="color: black;">
                <label>License</label>
                <input type="text" name="license" pattern="[a-zA-Z0-9]+"/>
            </div>

            <button onclick="submitform()" type="submit" name="search" value="Search">Search</button> <!-- value is what is submitted to server onclick="return submitform();"-->
        </form>
        <script>
            function submitform() {
                if ( (searchPeople.name.value != null || searchPeople.license.value != null) && !(searchPeople.name.value == "" && searchPeople.license.value == "")) {
                    //alert("Form is okay!");
                    //return (true);
                } 
                else {
                    alert("You must enter at least one field!");
                    //return (false);
                }
            }
        </script>
        <footer><a style="color:white;" href="welcome.php">Back to home page</a></footer>
        <?php  
            require("config.php");
            //session_start()
            //if (isset($_POST['Search']))
            //echo "Success";
            if (isset($_POST['name']) && $_POST['name'] != "" || isset($_POST['license']) && $_POST['license'] != "" ) 
            {
                //echo "Success";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if(!$conn) {
                    die ("Connection failed");
                }
                else
                {
                    if($_POST['license'] == "")
                    {
                        //echo "First";
                        $name = $_POST['name'];
                        $sql1 = "SELECT * FROM People WHERE People_name LIKE \"%".$name."%\";"; //COLLATE utf8mb4_unicode_ci
                        //$sql3 = "SELECT * FROM People WHERE People_name='$name';";
                        $result1 = mysqli_query($conn, $sql1);
                        if (mysqli_num_rows($result1) > 0) 
                        {
                            echo "<br><table style=\"margin-left: auto; margin-right: auto;\">";  // start table
                            echo "<tr><th>ID</th><th>Name</th><th>Address</th><th>Licence</th></tr>"; // table header
                        
                        // loop through each row of the result (each tuple will  
                        // be contained in the associative array $row)
                            while($row1 = mysqli_fetch_assoc($result1)) 
                            {
                                //echo var_dump($row1);
                                // output UD, name , address, and license
                                echo "<tr>";
                                echo "<td>".$row1["People_ID"]."</td>"; 
                                echo "<td>".$row1["People_name"]."</td>";
                                echo "<td>".$row1["People_address"]."</td>";
                                echo "<td>".$row1["People_licence"]."</td>";
                                echo "</tr>";
                            } 
                            echo "</table>"; 
                        }
                        else 
                        {
                            echo "<script>alert('Name Not Found!');</script>";
                            //echo "Query not found!";
                        }
                    }
                    else
                    {
                        //echo "Second";
                        //$name = $_POST['name'];
                        $license = $_POST['license'];
                        $sql2 = "SELECT * FROM People WHERE People_licence = '$license';";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                            echo "<br><table>";  // start table
                            echo "<tr><th>People_ID</th><th>People_name</th><th>People_address</th><th>People_licence</th></tr>"; // table header
                        
                        // loop through each row of the result (each tuple will  
                        // be contained in the associative array $row)
                            while($row2 = mysqli_fetch_assoc($result2)) 
                            {
                                // output name and phone number as table row
                                echo "<tr>";
                                echo "<td>".$row2["People_ID"]."</td>"; 
                                echo "<td>".$row2["People_name"]."</td>";
                                echo "<td>".$row2["People_address"]."</td>";
                                echo "<td>".$row2["People_licence"]."</td>";
                                
                                echo "</tr>";
                            } 
                            echo "</table>"; 
                        }
                        else
                        {
                            echo "<script>alert('License Not Found');</script>";
                            //echo "Query not found!";
                        }

                    }
                }
                    
            }                                                         
            mysqli_close($conn);
            
        ?>
        </main>      
    </body>
</html>