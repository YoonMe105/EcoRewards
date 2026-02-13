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

if (!isset($_GET['id'])) { 
    header("Location: rewards.php"); exit(); }
$rewardId = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch Logic
$query = "SELECT * FROM rewards WHERE id = '$rewardId' AND partners_id = '{$partner['id']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);


if (!$row) { echo "Reward not found."; exit(); }

// Update Logic
if (isset($_POST['btnUpdate'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $qty = $_POST['quantity'];
    $points = $_POST['points_required'];
    $expiry = $_POST['expired_at'];
    $status = $_POST['status'];

    $sql = "UPDATE rewards SET name='$name', description='$desc', quantity='$qty', points_required='$points', expired_at='$expiry', status='$status' WHERE id='$rewardId'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated successfully!'); window.location.href='rewards.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reward</title>
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
            <h1>Edit Reward</h1>
            <a href="rewards.php" class="btn" style="background:#999;">Cancel</a>
        </header>

        <div class="card" style="max-width: 600px;">
            <form method="POST">
                <div class="form-group">
                    <label>Reward Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?= htmlspecialchars($row['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="<?= $row['quantity'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Points Required</label>
                    <input type="number" name="points_required" value="<?= $row['points_required'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Expiry</label>
                    <input type="datetime-local" name="expired_at" value="<?= date('Y-m-d\TH:i', strtotime($row['expired_at'])) ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="available" <?= $row['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                        <option value="outofstock" <?= $row['status'] == 'outofstock' ? 'selected' : '' ?>>Out of Stock</option>
                        <option value="expired" <?= $row['status'] == 'expired' ? 'selected' : '' ?>>Expired</option>
                    </select>
                </div>
                <button type="submit" name="btnUpdate" class="btn btn-block">Save Changes</button>
            </form>
        </div>
    </main>
</div>
</body>

</html>
