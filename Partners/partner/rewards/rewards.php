<?php
session_start();
if (!isset($_SESSION['partners'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../../config/dbcon.php";
$partner = $_SESSION['partners'];
$partnerId = $partner['id'];

$updateSql = "UPDATE rewards 
              SET status = 'expired' 
              WHERE expired_at < NOW() AND status != 'expired' AND partners_id = $partnerId";
mysqli_query($conn, $updateSql);

// Get reward statistics
$totalRewards = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rewards WHERE partners_id=$partnerId")
)['total'] ?? 0;

$updateSql = "UPDATE rewards 
              SET status = 'expired' 
              WHERE expired_at < NOW() AND status != 'expired' AND partners_id = $partnerId";
mysqli_query($conn, $updateSql);

$totalRedemptions = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM reward_redemption WHERE rewards_id IN (SELECT id FROM rewards WHERE partners_id=$partnerId)")
)['total'] ?? 0;

$availableCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rewards WHERE partners_id=$partnerId AND expired_at > NOW() AND status='available'"))['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards Management</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <style>
        /* Small styling for the button group inside cards */
        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .btn-small {
            flex: 1;
            text-align: center;
            padding: 8px;
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-view { background: #f3f4f6; color: #374151; }
        .btn-view:hover { background: #e5e7eb; }
        
        .btn-edit { background: #10b981; color: white; }
        .btn-edit:hover { background: #059669; }
    </style>
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
                $imagePath = "../../img/" . $partner['name'] . ".png";
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
                <h1>Rewards Management</h1>
                <p class="subtitle">System Time: <?= date('Y-m-d H:i:s') ?></p>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <a href="createReward.php" class="btn" style="background-color: #1b7f4b; text-decoration: none; color: white;">+ Create Reward</a>
                <a href="../../auth/logout.php" class="btn" style="background-color: #ef4444; text-decoration: none; color: white;">Logout</a>
            </div>
        </header>
            

        <section class="metrics">
            <div class="metric-card">
                <div class="metric-icon">🎁</div>
                <div class="metric-label">Total Rewards</div>
                <div class="metric-value"><?= $totalRewards ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-icon">🏃</div>
                <div class="metric-label">Available</div>
                <div class="metric-value"><?= $availableCount ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-icon">🔄</div>
                <div class="metric-label">Redemptions</div>
                <div class="metric-value"><?= $totalRedemptions ?></div>
            </div>
        </section>

        <h3 style="margin-bottom: 15px;">Available Rewards</h3>
        <div class="grid-3">
            <?php
            $sqlAvailable = "SELECT * FROM rewards 
                             WHERE partners_id = $partnerId 
                             AND expired_at > NOW() 
                             ORDER BY created_at DESC";
            
            $result = mysqli_query($conn, $sqlAvailable);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    // Determine styling based on stock status
                    $border = ($row['status'] == 'outofstock') ? '#f59e0b' : '#10b981';
                    $badge  = ($row['status'] == 'outofstock') ? 'Out of Stock' : 'Available';
                    $bg     = ($row['status'] == 'outofstock') ? '#fef3c7' : '#d1fae5';
                    $color  = ($row['status'] == 'outofstock') ? '#92400e' : '#065f46';

                    echo '<div class="card" style="border-left: 5px solid ' . $border . ';">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>' . htmlspecialchars($row['description']) . '</p>
                            
                            <div style="display:flex; justify-content:space-between; align-items:center; margin:10px 0;">
                                <span style="background:' . $bg . '; color:' . $color . '; padding:4px 10px; border-radius:15px; font-size:12px; font-weight:bold;">' . $badge . '</span>
                                <span style="font-size:13px; color:#666;">Stock: <b>' . $row['quantity'] . '</b></span>
                            </div>

                            <div class="card-actions">
                                <a href="viewReward.php?id=' . $row['id'] . '" class="btn-small btn-view">View</a>
                                <a href="editReward.php?id=' . $row['id'] . '" class="btn-small btn-edit">Edit</a>
                            </div>
                          </div>';
                }
            } else { echo '<p style="color:#666;">No available rewards found.</p>'; }
            ?>
        </div>

        <h3 style="margin: 30px 0 15px;">Past Rewards (Expired)</h3>
        <div class="grid-3">
            <?php
            $sqlPast = "SELECT * FROM rewards 
                        WHERE partners_id = $partnerId 
                        AND expired_at < NOW() 
                        ORDER BY expired_at DESC";
            
            $result = mysqli_query($conn, $sqlPast);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="card" style="border-left: 5px solid #9ca3af; opacity:0.8;">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p style="color:#666;">Ended: ' . $row['expired_at'] . '</p>
                            
                            <span style="background:#e5e7eb; color:#374151; padding:4px 10px; border-radius:15px; font-size:12px;">Expired</span>

                            <div class="card-actions">
                                <a href="viewReward.php?id=' . $row['id'] . '" class="btn-small btn-view">View</a>
                                <a href="editReward.php?id=' . $row['id'] . '" class="btn-small btn-edit">Edit</a>
                            </div>
                          </div>';
                }
            } else { echo '<p style="color:#666;">No past rewards.</p>'; }
            ?>
        </div>
    </main>
</div>

</body>
</html>