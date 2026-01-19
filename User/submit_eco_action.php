<?php
require "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    exit("Not logged in");
}

$userId = $_SESSION['user_id'];

$date = $_POST['action_date'];
$material = $_POST['material_type'];
$qty = (int)$_POST['quantity'];
$points = $qty * 5;

/* IMAGE UPLOAD */
$imgName = time() . "_" . $_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], "../image/".$imgName);

/* INSERT ACTION */
$stmt = $conn->prepare("
  INSERT INTO eco_actions 
  (users_id, material_type, image, quantity, points_earned, status, created_at)
  VALUES (?, ?, ?, ?, ?, 'archived', NOW())
");
$stmt->bind_param("issii", $userId, $material, $imgName, $qty, $points);
$stmt->execute();

/* UPDATE USER POINTS */
$update = $conn->prepare("
  UPDATE users SET user_points = user_points + ? WHERE id = ?
");
$update->bind_param("ii", $points, $userId);
$update->execute();

echo "Eco action submitted successfully!";
?>