<?php
session_start();
if (!isset($_SESSION['partner'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../config/db.php";
$partnerId = $_SESSION['partner']['id'];

$updateSql = "UPDATE rewards 
              SET status = 'expired' 
              WHERE expired_at < NOW() AND status != 'expired' AND partners_id = $partnerId";
mysqli_query($conn, $updateSql);

// Get reward statistics
$totalRewards = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rewards WHERE partners_id=$partnerId")
)['total'] ?? 0;

$ongoingRewards = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rewards WHERE partners_id=$partnerId AND status='available'")
)['total'] ?? 0;

$totalRedemptions = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM reward_redemption WHERE rewards_id IN (SELECT id FROM rewards WHERE partners_id=$partnerId)")
)['total'] ?? 0;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards Management</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/rewards.css">
</head>
<body>

<<header class="app-header">
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
            <div>
                <h1>Rewards Management</h1>
                <p class="subtitle">System Time: <?= date('Y-m-d H:i:s') ?></p>
            </div>
            <a href="createReward.php" class="create-btn">+ Create Reward</a>
        </div>

        <section class="reward-stats">
            <div class="stat-card">
                <div class="stat-icon">🎁</div>
                <div class="stat-content">
                    <div class="stat-label">Total Rewards</div>
                    <div class="stat-value"><?= $totalRewards ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏃</div>
                <div class="stat-content">
                    <div class="stat-label">Ongoing Rewards</div>
                    <div class="stat-value"><?= $ongoingCount ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🔄</div>
                <div class="stat-content">
                    <div class="stat-label">Redemptions</div>
                    <div class="stat-value"><?= $totalRedemptions ?></div>
                </div>
            </div>
        </section>

        <section class="rewards-section">
            <h2>🟢 Ongoing Rewards (Current Time < Expiry)</h2>
            <div class="rewards-grid">
                <?php
                // Step 2 - Create SQL query using Date Comparison
                $sqlOngoing = "SELECT * FROM rewards 
                               WHERE partners_id = $partnerId 
                               AND start_date <= NOW() 
                               AND expired_at > NOW() 
                               ORDER BY expired_at ASC";
                $result = mysqli_query($conn, $sqlOngoing);

                // Step 3 - Display Data
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="reward-card">
                                <div class="reward-header"><span class="reward-badge active">Active</span></div>
                                <div class="reward-icon">🎁</div>
                                <h3>' . $row['name'] . '</h3>
                                <p>' . $row['description'] . '</p>
                                <div class="reward-footer">
                                    <span>Stock: ' . $row['quantity'] . '</span>
                                    <span>' . $row['points_required'] . ' pts</span>
                                </div>
                              </div>';
                    }
                } else { echo '<p class="no-data">No active rewards.</p>'; }
                ?>
            </div>
        </section>

        <section class="rewards-section">
            <h2>🔵 Upcoming Rewards (Start Date > Current Time)</h2>
            <div class="rewards-grid">
                <?php
                $sqlUpcoming = "SELECT * FROM rewards 
                                WHERE partners_id = $partnerId 
                                AND start_date > NOW() 
                                ORDER BY start_date ASC";
                $result = mysqli_query($conn, $sqlUpcoming);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="reward-card upcoming">
                                <div class="reward-header"><span class="reward-badge upcoming-badge">Upcoming</span></div>
                                <div class="reward-icon">⏳</div>
                                <h3>' . $row['name'] . '</h3>
                                <p>Starts on: ' . $row['start_date'] . '</p>
                                <div class="reward-footer">
                                    <span>Points: ' . $row['points_required'] . '</span>
                                </div>
                              </div>';
                    }
                } else { echo '<p class="no-data">No upcoming rewards.</p>'; }
                ?>
            </div>
        </section>

        <section class="rewards-section">
            <h2>🔴 Past Rewards (Current Time > Expiry)</h2>
            <div class="rewards-grid">
                <?php
                $sqlPast = "SELECT * FROM rewards 
                            WHERE partners_id = $partnerId 
                            AND expired_at < NOW() 
                            ORDER BY expired_at DESC";
                $result = mysqli_query($conn, $sqlPast);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="reward-card past">
                                <div class="reward-header"><span class="reward-badge past-badge">Expired</span></div>
                                <div class="reward-icon">🔒</div>
                                <h3>' . $row['name'] . '</h3>
                                <p>Ended on: ' . $row['expired_at'] . '</p>
                                <div class="reward-footer">
                                    <span>Status: ' . $row['status'] . '</span>
                                </div>
                              </div>';
                    }
                } else { echo '<p class="no-data">No past history found.</p>'; }
                
                // Step 4 - Close connection
                mysqli_close($conn);
                ?>
            </div>
        </section>
    </main>
</div>

</body>
</html>