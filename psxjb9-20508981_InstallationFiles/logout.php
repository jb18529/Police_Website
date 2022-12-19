
<?php
    
    // Initialize the session.
    session_start();
    // Unset all of the session variables.
    unset($_SESSION['log']);
    unset($_SESSION['error']);
    unset($_SESSION['licence']);
    unset($_SESSION['vID']);
    unset($_SESSION['message']);
    unset($_SESSION['p_ID']);
    unset($_SESSION['I_ID']);
    unset($_SESSION['error']);
    // Finally, destroy the session.    
    session_destroy();

    // Include URL for Login page to login again.
    header("Location: login.php");
    exit();
?>

