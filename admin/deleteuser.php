<?php

    include "conn.php"; 
    $id=intval($_GET['id']);
    $sql="DELETE FROM users WHERE id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if(mysqli_affected_rows($dbConn)<=0) { 
        echo "<script>alert('Unable to delete data!');"; 
        die ("window.location.href='users.php';</script>"); 
    } 

    echo "<script>alert('Data deleted!');</script>"; 
    echo "<script>window.location.href='users.php';</script>"; 


?>
