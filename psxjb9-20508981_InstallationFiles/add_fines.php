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
        <title>Add New Fines</title>
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
            <h1 style="font-weight: bold; color: blue; background-color:grey;">Add Fines</h1>
            <form  method="POST" action="add_fines.php"  name="addFines" style="width: 770px;" >
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Fine Amount:</label> 
                    <input type="text" name="amount" required><br/>
                </div>
                <div class="form-element" style="color: black; font-size: 1.0rem;">
                    <label >Fine Points:</label> 
                    <input type="text" name="points" required><br/>
                </div>
                <label style="color: black; font-size: 1.0rem;">Incidents: </label><br><br>
                <?php
                    //Dropdown menu for Incident
                    //Get the value from POST name of the select findout what post returns
                    require("config.php");
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $sql1 = "SELECT * FROM Incident;";
                    $all_incidents = mysqli_query($conn, $sql1);
                    echo "<select name=incidents value=''></option>"; // list box select command
                    while($row1 = mysqli_fetch_assoc($all_incidents)){//Array or records stored in $row
                        echo "<option value=".$row1['Incident_ID']."> Vehicle ID: ".$row1['Vehicle_ID']." People ID: ".$row1['People_ID']." Date: ".$row1['Incident_Date']." Report: ".$row1['Incident_Report'].". Offence ID: ".$row1['Offence_ID']."</option>"; 
                    /* Option values are added by looping through the array */ 
                    }
                    echo "</select>";// Closing of list box
                ?>
                <br><br><button type="submit" name="submit" value="submit">Submit</button>
            </form>

            <footer style="text-align:center;"><a href="welcome.php" style="color:white;">Back to home page</a></footer>
            <?php  
                require("config.php");
                $conn = new mysqli($servername, $username, $password, $dbname);
                //echo "Success";

                if(isset($_POST['submit']))
                {
                    if ((isset($_POST['amount']) && $_POST['amount'] != "") && (isset($_POST['points']) && $_POST['points'] != "") && (isset($_POST['incidents'])))
                    {
                        $amount = $_POST['amount'];
                        $points = $_POST['points'];
                        $incidents = $_POST['incidents'];
                        $sql2 = "INSERT INTO Fines(Fine_Amount, Fine_Points, Incident_ID) VALUES ('$amount','$points', '$incidents');"; 
                        //echo "sql2=".$sql2."<br/>"; //print out insert statement
                        $result2 = mysqli_query($conn, $sql2);
                    } 
                }
                                                                       
                mysqli_close($conn);
                
            ?>
        </main>
        
    </body>
    
</html>
