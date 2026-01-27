<?php
require "db.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit;
}

$id = $_SESSION["user_id"];

$sql = "SELECT username, profile_image, total_points, uncollected_points
        FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());
?>
