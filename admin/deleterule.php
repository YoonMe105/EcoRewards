<?php

    include "conn.php"; 
    $id=intval($_GET['id']);
    $sql="DELETE FROM point_rules WHERE id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if(mysqli_affected_rows($dbConn)<=0) { 
        echo "<script>alert('Unable to delete data!');"; 
        die ("window.location.href='pointsrule.php';</script>"); 
    } 

    echo "<script>alert('Data deleted!');</script>"; 
    echo "<script>window.location.href='pointsrule.php';</script>"; 


?>
