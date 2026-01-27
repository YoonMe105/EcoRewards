<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include "db.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId"))['count'] ?? 0;
$totalParticipants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM event_logs WHERE events_id IN (SELECT id FROM events WHERE partners_id = $partnerId)"))['count'] ?? 0;
$eventCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM events WHERE partners_id={$partner['id']}")
)['total'];

$rewardCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM rewards WHERE partners_id={$partner['id']}")
)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title> Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
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
                $imagePath = "image/" . $partner['name'] . ".png";
            if (file_exists($imagePath)) {
                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
        } else {
            // 3. Fallback to icon if no file named "Name.png" is found
            echo '<span style="font-size: 30px;">👤</span>' 
        ;}

        ?>
        </div>
        <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partner['name']) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="partner_homepage.php" class="nav-item active">Dashboard</a>
            <a href="marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events/events.php" class="nav-item">Events</a>
            <a href="rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <div>
                <h1>Dashboard</h1>
            </div>
            <a href="../login/logout.php" class="btn" style="background-color: #ef4444; text-decoration: none; color: white;">Logout</a>
        </header>

        <section class="metrics">
            <div class="metric-card">
                <div class="metric-icon">📅</div>
                <div class="metric-label">Total Events</div>
                <div class="metric-value"><?= $totalEvents ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-icon">👥</div>
                <div class="metric-label">Total Participants</div>
                <div class="metric-value"><?= $totalParticipants ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-icon">🎁</div>
                <div class="metric-label">Rewards Created</div>
                <div class="metric-value"><?= $rewardCount ?></div>
            </div>
        </section>

        <section class="grid-3">
             <div class="card">
                <h3>Marketing Analysis</h3>
                <p>View detailed analytics and insights about your events.</p>
                <a href="marketing.php" class="btn">View Analytics</a>
             </div>
             <div class="card">
                <h3>Manage Events</h3>
                <p>Create new events or manage existing ones.</p>
                <a href="events/events.php" class="btn">Go to Events</a>
             </div>
             <div class="card">
                <h3>Create Rewards</h3>
                <p>Add new vouchers or items for users to redeem.</p>
                <a href="rewards/createReward.php" class="btn">Add Reward</a>
             </div>
        </section>
    </main>
</div>
</body>
</html>
            
        

        
    

        
    



