<?php 
    session_start();
    if(isset($_SESSION['user_logged'])) {
        session_destroy();
        header("Location:login.php");
    }
?>