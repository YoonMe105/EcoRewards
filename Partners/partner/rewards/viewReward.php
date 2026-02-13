<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../../User/login.php");
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
        <div class="sidebar-top">
            <div class="logo">EcoRewards</div>
        </div>

        <div class="profile" style="padding: 20px; text-align: center; border-bottom: 1px solid #f3f4f6;">
            <div class="avatar-circle" style="width: 80px; height: 80px; margin: 0 auto 10px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
               <?php 
                $imagePath = "../../image/" . $partner['name'] . ".png";
                if (file_exists($imagePath)) {
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
                } else {
                    echo '<span style="font-size: 30px;">👤</span>';
                }
                ?>

        ?>
        </div>
        <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partner['name']) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>
        <nav class="nav">
            <a href="../dashboard.php" class="nav-item">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="../events/events.php" class="nav-item">Events</a>
            <a href="rewards.php" class="nav-item active">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
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
