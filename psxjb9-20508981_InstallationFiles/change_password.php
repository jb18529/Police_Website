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
        <title>Change Password</title>
        <link rel="stylesheet" href="style1.css">
        <style>
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
        <h1 style="font-weight: bold; color: blue; background-color:grey;">Change Password</h1>
        <form method="POST" action="" name="chgPass">
            <div class="form-element" style="color: black;">
                <label>Current Password</label>
                <input type="password" name="currentPassword" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-element" style="color: black;">
                <label> New Password</label>
                <input type="password" name="newPassword" required />
            </div>
            <div class="form-element" style="color: black;">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" required />
            </div>
            <button type="submit" name="submit" value="Submit">Submit</button> 
            <div class="form-error">
                <?php 
                    if(isset($_SESSION["message"])) 
                    { 
                        $message = $_SESSION["message"]; 
                        echo '<p>'.$message.'</p>'; 
                    } 
                    else{
                        echo "is not set";
                    }
                
                ?>
            </div>    
        </form>

        <footer><a href="welcome.php" style="color:white;">Back to home page</a></footer>
        <?php
            //session_start();
            require("config.php");
            $conn = new mysqli($servername, $username, $password, $dbname);
            //echo "you are in change_password page";
            //$uname_logged = $_SESSION['log'];
            // if(!isset($_SESSION['log']))
            // {   
            // }
            if(isset($_POST['submit']))
            {
                $uname_logged = $_SESSION['log'];
                //$conn = new mysqli($servername, $username, $password, $dbname);
                $oldPass = $_POST['currentPassword'];
                $newPass = $_POST['newPassword'];
                $confirmPass = $_POST['confirmPassword'];
                $sql1= "SELECT Password from Users WHERE Username='$uname_logged' and Password = '$oldPass';";
                $query1 = mysqli_query($conn, $sql1);
                
                if(mysqli_num_rows($query1) > 0)
                {
                    if($newPass == $confirmPass)
                    {
                        $sql2 = "UPDATE Users SET Password = '$confirmPass' WHERE Username = '$uname_logged';";
                        $query2 = mysqli_query($conn, $sql2);
                    
                        //echo "Success";
                        $message = "Password Changed!";
                        $_SESSION["message"] = $message;

                        header('Location: change_password.php');

                        exit();
                        
                    }
                    else
                    {
                        
                        $message = "New Password does not match with Confirm Password";
                        $_SESSION["message"] = $message;
                        header('Location: change_password.php');
                        exit();
                    }
                }
                else
                {
                    $message = "Wrong Current Password!";
                    $_SESSION["message"] = $message;
                    header('Location: change_password.php');
                    exit();
                }
            }
            mysqli_close($conn);
        ?>

        </main>

        

    </body>

</html>

<?php
unset($_SESSION["message"]);
?>

