<?php
    session_start();
    if(isset($_SESSION['log']))
    {
        echo "User is:".$_SESSION['log']."<br";
    }
    else
    {
        echo "logout successful";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Form</title>
        
    </head>

    <body>
        <link rel="stylesheet" type="text/css" href="style1.css" media="screen" /> 
        <h1>Traffic Police Database</h1>
        <form method="POST" action="" name="signin-form">
            <div class="form-element">
                <label>Username</label>
                <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-element">
                <label>Password</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit" name="login" value="login">Log In</button>
            <div class ="form-error">
                <?php
                    if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo '<p style="color: red;">'.$error.'</p>';
                    }
                ?>
            </div>
        
            
        </form>


    <?php
        require("config.php");

        
        if(isset($_POST['login'])) 
        {
            
            $conn = new mysqli($servername, $username, $password, $dbname);


            $uname = $_POST['username'];
            $pass = $_POST['password'];
            $error = "Username/Password Incorrect";
            //$query = $conn->prepare("SELECT * FROM Users WHERE username=:username");
            $sql = "SELECT * FROM Users WHERE Username='$uname' and Password='$pass' COLLATE utf8mb4_bin;";
            //$query->bind_param("username", $username);
            //$query -> execute();
            //$result = $query->get_result();
            $query = mysqli_query($conn, $sql);
            //$stmt = $result -> get_result();
            if(mysqli_num_rows($query) > 0)
            {
                $_SESSION['log'] = $uname; //will record which user is logged in
                unset($_SESSION["error"]);
                header('Location: welcome.php');
                exit();
                //$err = "Wrong Username and/or Password";
                //echo $err;
            }
            else
            {

                //echo "Wrong username/password";
                $_SESSION["error"] = $error;
                
                header('Location: login.php');
                exit();

            }

            
        }
        mysqli_close($conn);
        
    ?>

    </body>
</html>

<?php
    unset($_SESSION["error"]);
?>


