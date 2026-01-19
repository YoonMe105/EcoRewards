<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "ecoreward";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed");
}
?>

