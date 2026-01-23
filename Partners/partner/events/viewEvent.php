<?php
session_start();
if (!isset($_SESSION['partners'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../../config/dbcon.php";
$partner = $_SESSION['partners'];
$partnerId = $partner['id'];

if (!isset($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$eventId = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM events WHERE id = '$eventId' AND partners_id = '$partnerId'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Event not found.";
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Event Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top"><div class="logo">EcoRewards</div></div>
        
        <div class="profile" style="padding: 20px; text-align: center; border-bottom: 1px solid #f3f4f6;">
            <div class="avatar-circle" style="width: 80px; height: 80px; margin: 0 auto 10px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <?php 
                $partnerName = $_SESSION['partners']['name'];
                $imagePath = "../../img/" . $partnerName . ".png";
                if (file_exists($imagePath)) {
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
                } else {
                    echo '<span style="font-size: 30px;">👤</span>';
                }
                ?>
            </div>
            <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partnerName) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="../dashboard.php" class="nav-item">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events.php" class="nav-item active">Events</a>
            <a href="../rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <div>
                <h1>Event Details</h1>
                <p>Viewing details for ID: #<?= $row['id'] ?></p>
            </div><br>
            <a href="events.php" class="btn" style="background: #9ca3af;">Back to List</a>
        </header>

        <div class="card" style="display: flex; gap: 30px; max-width: 900px; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 300px;">
                <?php if(!empty($row['image'])): ?>
                    <img src="../../<?= $row['image'] ?>" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <?php else: ?>
                    <div style="width: 100%; height: 200px; background: #eee; border-radius: 12px; display: flex; align-items: center; justify-content: center;">No Image Available</div>
                <?php endif; ?>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="editEvent.php?id=<?= $row['id'] ?>" class="btn btn-block">Edit This Event</a>
                </div>
            </div>

            <div style="flex: 1.5; min-width: 300px;">
                <h2 style="font-size: 24px; color: #333; margin-bottom: 10px;"><?= htmlspecialchars($row['name']) ?></h2>
                
                <span style="background: #e0f2fe; color: #0369a1; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase;">
                    <?= htmlspecialchars($row['status']) ?>
                </span>

                <div style="margin-top: 20px; line-height: 1.8; color: #555;">
                    <h4 style="color: #333; margin-bottom: 5px;">Description</h4>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                </div>

                <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                    <div>
                        <h4 style="color: #999; font-size: 12px; text-transform: uppercase;">Start Date</h4>
                        <p style="font-weight: 600; font-size: 16px;"><?= date('F j, Y, g:i a', strtotime($row['start_date'])) ?></p>
                    </div>
                    <div>
                        <h4 style="color: #999; font-size: 12px; text-transform: uppercase;">End Date</h4>
                        <p style="font-weight: 600; font-size: 16px;"><?= date('F j, Y, g:i a', strtotime($row['end_date'])) ?></p>
                    </div>
                    <div>
                        <h4 style="color: #999; font-size: 12px; text-transform: uppercase;">Points Reward</h4>
                        <p style="font-weight: 600; font-size: 16px; color: #10b981;"><?= $row['points_reward'] ?> pts</p>
                    </div>
                    <div>
                        <h4 style="color: #999; font-size: 12px; text-transform: uppercase;">Created On</h4>
                        <p style="color: #666; font-size: 14px;"><?= date('Y-m-d', strtotime($row['created_at'])) ?></p>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>