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

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId"))['count'] ?? 0;
$ongoingCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId AND end_date > NOW() AND start_date <= NOW()"))['count'] ?? 0;
// Step 3: GET STATISTICS (Live Data)
// Total Participants joined for the logged-in partner's events
$totalParticipants = 0; 

// We join 'event_logs' with 'events' to filter by the current partner's ID
$partQuery = mysqli_query($conn, "SELECT COUNT(event_logs.id) as count 
                                  FROM event_logs 
                                  JOIN events ON event_logs.events_id = events.id 
                                  WHERE events.partners_id = $partnerId");

if($partQuery) {
    $totalParticipants = mysqli_fetch_assoc($partQuery)['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Management</title>
    
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
                $imagePath = "../../image/" . $partner['name'] . ".png";
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
            <a href="../dashboard.php" class="nav-item ">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events.php" class="nav-item active">Events</a>
            <a href="../rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

        
        <main class="main">
        <div class="main-header">
            <h1>Events Management</h1>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="createEvent.php" class="btn" style="background-color: #1b7f4b; text-decoration: none; color: white;">+ Create Event</a>
            <a href="../../../User/php/login.php" class="btn" style="background-color: #ef4444; text-decoration: none; color: white;">Logout</a>
        </div>

        <section class="metrics">
            <div class="metric-card">
                <div class="metric-icon">📅</div>
                <div class="metric-label">Total Events</div>
                <div class="metric-value"><?= $totalEvents ?></div>
            </div>
            <div class="metric-card">
                <div class="metric-icon">⏳</div>
                <div class="metric-label">Ongoing Events</div>
                <div class="metric-value"><?= $ongoingCount ?></div>
            </div>
        </section>


        <h3 style="margin: 30px 0 15px;">Past Events</h3>
        <div class="grid-3">
            <?php
            // Logic: End Date is in the past (less than NOW)
            $query = "SELECT * FROM events WHERE partners_id = $partnerId AND start_date <= NOW() AND end_date < NOW() ORDER BY end_date DESC"; 
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){ 
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="card" style="border-left: 5px solid #9ca3af; opacity: 0.8;">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p style="color: #666; font-size: 13px;">Ended: ' . $row['end_date'] . '</p>
                            <span style="background:#e5e7eb; color:#374151; padding:5px 10px; border-radius:15px; font-size:12px;">Completed</span>
                          <div class="card-actions">
                                <a href="viewEvent.php?id=' . $row['id'] . '" class="btn-small btn-view">View Details</a>
                                <a href="editEvent.php?id=' . $row['id'] . '" class="btn-small btn-edit">Edit</a>
                            </div>
                         </div>';
                }
            } else { echo '<p style="color:#666;">No past events found.</p>'; }
            ?>
        </div>

        <h3 style="margin-bottom: 15px;">Ongoing Events</h3>
        <div class="grid-3">
            <?php
            $query = "SELECT * FROM events WHERE partners_id = $partnerId AND end_date < NOW() ORDER BY end_date DESC"; 
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="card" style="border-left: 5px solid #10b981;">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>' . htmlspecialchars($row['description']) . '</p>
                            <span style="background:#d1fae5; color:#065f46; padding:5px 10px; border-radius:15px; font-size:12px;">Ongoing</span>
                          
                          <div class="card-actions">
                                <a href="viewEvent.php?id=' . $row['id'] . '" class="btn-small btn-view">View Details</a>
                                <a href="editEvent.php?id=' . $row['id'] . '" class="btn-small btn-edit">Edit</a>
                            </div>
                         </div>';
                }
            } else { echo '<p style="color:#666;">No ongoing events.</p>'; }
            ?>
        </div>

        <h3 style="margin: 30px 0 15px;">Upcoming Events</h3>
        <div class="grid-3">
            <?php
            $query = "SELECT * FROM events WHERE partners_id = $partnerId AND start_date > NOW()"; 
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="card" style="border-left: 5px solid #f59e0b;">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>Starts: ' . $row['start_date'] . '</p>
                            <span style="background:#fef3c7; color:#92400e; padding:5px 10px; border-radius:15px; font-size:12px;">Upcoming</span>
                          <div class="card-actions">
                                <a href="viewEvent.php?id=' . $row['id'] . '" class="btn-small btn-view">View Details</a>
                                <a href="editEvent.php?id=' . $row['id'] . '" class="btn-small btn-edit">Edit</a>
                            </div>
                         </div>';
                }
            } else { echo '<p style="color:#666;">No upcoming events.</p>'; }
            ?>
        </div>
    </main>
</div>
</body>
</html>