<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../login/login.php");
    exit;
}

include "../../config/dbcon.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

if (isset($_POST['btnCreate'])) {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);          // Match HTML name="name"
    $desc        = mysqli_real_escape_string($conn, $_POST['description']);   // Match HTML name="description"
    $qty         = mysqli_real_escape_string($conn, $_POST['quantity']);      // Match HTML name="quantity"
    $points      = mysqli_real_escape_string($conn, $_POST['points_required']);// Match HTML name="points_required"
    $expiry_at   = mysqli_real_escape_string($conn, $_POST['expired_at']);    // Match HTML name="expired_at"
    $status      = mysqli_real_escape_string($conn, $_POST['status']);        // Match HTML name="status"
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reward - EcoRewards</title>
    
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
            <div>
                <h1>Create a New Reward</h1>
                <a href="rewards.php" class="btn" style="background: #999;">Back</a>

            </div>
        </header>
        

      
        <div class="card" style="max-width: 800px;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Partner ID:</label>
                    <input type="number" name="partners_id" class="form-input" required value="<?= $partnerId ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Reward Name:</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" class="form-input" required></textarea>
                </div>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Points Required:</label>
                    <input type="number" name="points_required" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Expiry Date & Time:</label>
                    <input type="datetime-local" name="expired_at" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-input" required>
                        <option value="available">Available</option>
                        <option value="outofstock">Out of Stock</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <button type="submit" name="btnCreate" class="btnSubmit">Create Reward</button>
            </form>
        </div>
    </main>
</div>
</body>

</html>

