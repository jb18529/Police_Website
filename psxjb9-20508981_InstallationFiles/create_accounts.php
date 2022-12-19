<?php
    session_start();
    if(!(isset($_SESSION['log'])))
	{
		header('Location: login.php');
		exit();
	}
    if($_SESSION['log'] != "daniels")
    {
        header('Location: welcome.php');
        exit();
    }
?>
<html>
    <head>
        <title>Create New Accounts</title>
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
            <h1 style="font-weight: bold; color: blue; background-color:grey;">Create Police Officer Accounts</h1>
            <form  method="POST" action="create_accounts.php"  name="newAccount" style="width: 570px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label>Enter a Username:</label> 
                    <input type="text" name="newUsername" pattern="[a-zA-Z0-9]+" required><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Enter a Password:</label> 
                    <input type="password" name="newPassword" pattern="[a-zA-Z0-9]+" required><br/>
                </div>
                <button type="submit" name="submit" value="submit">Submit</button> <!-- value is what is submitted to server onclick="return submitform();"-->
            </form>
            <footer style="text-align:center;"><a href="welcome.php" style="color:white;">Back to home page</a></footer>
            <?php  
                require("config.php");
                $conn = new mysqli($servername, $username, $password, $dbname);

                //echo "Success";
                if(mysqli_connect_errno()) 
                {
                   echo "Failed to connect to MySQL: ".mysqli_connect_error();
                   die();
                } 

                if (isset($_POST['submit']))
                {
                    //echo "Success1";
                    $nUsername = $_POST['newUsername'];
                    $nPassword = $_POST['newPassword'];
                    $sql1 = "INSERT INTO Users (Username, Password) VALUES ('$nUsername','$nPassword');";
                    //echo "sql1=".$sql1."<br>";
                    $result1 = mysqli_query($conn, $sql1);
                    
                    $sql2 = "SELECT * FROM Users ORDER BY ID;";

                    // send query to database
                    $result2 = mysqli_query($conn, $sql2);

                    // display the number of rows returned
                    echo "<p>".mysqli_num_rows($result2)." rows</p>";

                    if (mysqli_num_rows($result2) > 0) 
                    {
                    echo "<table style=\"margin-left: auto; margin-right: auto;\">";  // start table
                    echo "<tr><th>Username</th><th>Password</th></tr>"; // table header
                    
                    // loop through each row of the result (each tuple will  
                    // be contained in the associative array $row)
                    while($row2 = mysqli_fetch_assoc($result2)) 
                    {
                        // output name and phone number as table row
                        echo "<tr>";
                        echo "<td>".$row2["Username"]."</td>"; 
                        echo "<td>".$row2["Password"]."</td>";
                        
                        echo "</tr>";
                    } 

                    echo "</table>"; 
                    }
                }                                                        

                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>

