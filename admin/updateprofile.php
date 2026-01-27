<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ./User/login.php");
    exit;
}

$id = $_SESSION['admin_id'];


// ================= UPDATE PROFILE =================
if (isset($_POST['updateProfile'])) {

    $fullname = mysqli_real_escape_string($dbConn, $_POST['fullname']);
    $email    = mysqli_real_escape_string($dbConn, $_POST['email']);
    $phone    = mysqli_real_escape_string($dbConn, $_POST['phone']);

    $sql = "UPDATE admins 
            SET fullname='$fullname', email='$email', phone='$phone'
            WHERE id=$id";

    if (mysqli_query($dbConn, $sql)) {
        header("Location: profile.php");
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($dbConn);
    }
}




?>


