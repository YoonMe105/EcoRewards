<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login/login.php");
    exit;
}

include "../config/db.php";

$message = '';
$error = '';

if (isset($_POST['btnCreate'])) {
    // IMITATING YOUR INSERT METHOD
    $partnerId   = $_SESSION['partner']['id'];
    $name        = $_POST['txtName'];
    $desc        = $_POST['txtDesc'];
    $points      = $_POST['txtPoints'];
    $qty         = $_POST['txtQty'];
    $expiry_at   = $_POST['expiry_date'];
    $status      = $_POST['status']; // Default status
    $created_at  = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO rewards (partners_id, name, description, points_required, quantity, expired_at, status, created_at)
                    VALUES ('$partnerId', '$name', '$desc', '$points', '$qty', '$expiry_at', '$status', '$created_at')";
    if(mysqli_query($conn, $insertQuery)){
        echo "<script>alert('Reward added successfully'); window.location.href='rewards.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Reward - EcoRewards</title>
    <link rel="stylesheet" href="assets/style.css">
    
</head>
<body>

<header class="app-header">
    <h1>EcoRewards</h1>
    <a href="auth/logout.php" class="logout-btn">Log out</a>
</header>

<div class="container">

    <aside class="sidebar">
        <nav>
            <a href="../partner/dashboard.php">Dashboard</a>
            <a href="../partner/marketing.php">Marketing Analysis</a>
            <a href="../partner/events/events.php" >Events</a>
            <a href="../partner/rewards/rewards.php" class="active">Rewards</a>
            <a href="../partner/profile.php">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <div class="main-header">
            <h1>Create a New Reward</h1>
            <p>Add a new reward to your catalog</p>
        </div>

      
        <div class="card">
            <form method="POST" class="form-grid">
                <div class="form-group">
                    Partner ID:
                    <input type="number" name="partners_id" required>
                </div>

                <div class="form-group">
                    Reward Name:
                    <input type="text" name="name" required>
                </div>

                <div class="form-group full">
                    Description:
                    <textarea name="description" required style="padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; resize: vertical;"></textarea>
                </div>

                <div class="form-group">
                    Quantity:
                    <input type="number" name="quantity" required>
                </div>

                <div class="form-group">
                    Points Required:
                    <input type="number" name="points_required" required>
                </div>

                <div class="form-group">
                    Expiry Date & Time:
                    <input type="datetime-local" name="expired_at" required>
                </div>

                <div class="form-group">
                    Status:
                    <select name="status" required >
                        <option value="available">Available</option>
                        <option value="outofstock">Out of Stock</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                

                <div class="form-group full button-group">
                    <button type="submit" class="btnCreate">Create Reward</button>
                </div>
            </form>
        </div>
    </main>

</div>

</body>
</html>