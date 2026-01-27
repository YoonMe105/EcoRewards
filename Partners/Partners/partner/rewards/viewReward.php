<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../php/login.php");
    exit();
}
include "../../php/db.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

if (!isset($_GET['id'])) { header("Location: rewards.php"); exit(); }
$rewardId = mysqli_real_escape_string($conn, $_GET['id']);

$query = "SELECT * FROM rewards WHERE id = '$rewardId' AND partners_id = '{$partner['id']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) { echo "Reward not found."; exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reward</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>
<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top"><div class="logo">EcoRewards</div></div>
        <nav class="nav">
            <a href="../partner_homepage.php" class="nav-item">Dashboard</a>
            <a href="rewards.php" class="nav-item active">Rewards</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <h1>Reward Details</h1>
            <a href="rewards.php" class="btn" style="background:#999;">Back</a>
        </header>

        <div class="card" style="max-width: 600px;">
            <h2 style="color:#10b981;"><?= htmlspecialchars($row['name']) ?></h2>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <hr style="margin: 20px 0; border:0; border-top:1px solid #eee;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <p><strong>Points Required:</strong> <?= $row['points_required'] ?></p>
                <p><strong>Quantity:</strong> <?= $row['quantity'] ?></p>
                <p><strong>Status:</strong> <?= ucfirst($row['status']) ?></p>
                <p><strong>Expiry:</strong> <?= $row['expired_at'] ?></p>
            </div>
            <a href="editReward.php?id=<?= $row['id'] ?>" class="btn btn-block" style="margin-top:20px;">Edit Reward</a>
        </div>
    </main>
</div>
</body>
</html>