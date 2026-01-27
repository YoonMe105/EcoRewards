<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['admin_id'];

$sql = "SELECT * FROM admins WHERE id = $id LIMIT 1";
$result = mysqli_query($dbConn, $sql);
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>

    

    
</body>
</html>