<?php
session_start();
if (!isset($_SESSION['partners'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../config/dbcon.php";
$partner = $_SESSION['partners'];
$partnerId = $partner['id'];


$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events"))['count'];
$ongoingCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId AND end_date > NOW() AND start_date <= NOW()"))['count'];
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
    <title>Events Management - EcoRewards</title>
    
   <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<header class="top-bar">
    <h1>EcoRewards</h1>
    <a href="logout.php" class="logout">Log out</a>
</header>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top"><div class="logo">🌱 EcoRewards</div></div>
        <nav class="nav">
            <a href="../dashboard.php" class="nav-item">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events.php" class="nav-item active">Events</a>
            <a href="../rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="content">
        
        <main class="main">
        <div class="main-header">
            <h1>Events Management</h1>
            <a href="createEvent.php" class="btn">+ Create Event</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-content">
                    <div class="stat-label">Total Events</div>
                    <div class="stat-value"><?= $totalEvents ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-content">
                    <div class="stat-label">Ongoing Events</div>
                    <div class="stat-value"><?= $ongoingCount ?></div>
                </div>
            </div>
        </div>

            <h3>Ongoing Events</h3>
        <div class="events-grid">
            <?php
            // Updated to use 'events' table
            $query = "SELECT * FROM events WHERE partners_id = $partnerId AND start_date <= NOW() AND end_date > NOW()"; 
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="event-card">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>' . htmlspecialchars($row['description']) . '</p>
                            <span class="active" style="padding:5px; border-radius:5px; width:fit-content; font-size:12px;">Ongoing</span>
                          </div>';
                }
            } else { echo '<p style="color:#666;">No ongoing events.</p>'; }
            ?>
        </div>

        <h3>Upcoming Events</h3>
        <div class="events-grid">
            <?php
            $query = "SELECT * FROM events WHERE partners_id = $partnerId AND start_date > NOW()"; 
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="event-card">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>Starts: ' . $row['start_date'] . '</p>
                            <span class="upcoming-badge" style="padding:5px; border-radius:5px; width:fit-content; font-size:12px;">Upcoming</span>
                          </div>';
                }
            } else { echo '<p style="color:#666;">No upcoming events.</p>'; }
            ?>
        </div>
    </main>
</div>
</body>
</html>

<?php
// Close database connection at the very end
mysqli_close($conn);
?>