<?php
    
    $localhost = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'ecorewards';

    $dbConn = mysqli_connect($localhost,$user,$pass,$dbname);
    
    if(mysqli_connect_errno()){
        die('<script>alert("Connection failed: Please Check your SQL connection statement.");</script>');
    }

    // echo '<script>alert("Successfully connect!");</script>';
?>