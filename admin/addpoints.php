<?php
include 'conn.php';

$id = (int) $_GET['id'];
$points = (int) $_GET['points'];

mysqli_query($dbConn,
    "UPDATE users SET user_points = user_points + $points WHERE id = $id"
);

header("Location: users.php");
exit;
?>