<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $_SESSION["user_id"];

if (isset($data["username"])) {
    $sql = "UPDATE users SET username=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $data["username"], $id);
    $stmt->execute();
}

if (isset($data["profile_image"])) {
    $sql = "UPDATE users SET profile_image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $data["profile_image"], $id);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
