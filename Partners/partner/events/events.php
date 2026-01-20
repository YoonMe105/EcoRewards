<?php
session_start();

// 1. SECURITY: Check if Partner is logged in
if (!isset($_SESSION["partners"])) {
    header("Location: ../login/login.php"); // Adjust path if needed
    exit;
}

// 2. CONNECTION: Connect to database
include "../config/db.php";

// 3. GET STATISTICS (Live Data)
// Total Events
$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events"))['count'];

// Ongoing Events (Events happening today)
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
    <title>Rewards Management - EcoRewards</title>
    
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/events.css">
    
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: sans-serif; background-color: #f4f6f8; }
        
        /* Layout */
        .top-bar { background: #10b981; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .logout { color: white; text-decoration: none; font-weight: bold; }
        
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: white; padding: 20px; border-right: 1px solid #eee; }
        .sidebar nav a { display: block; padding: 10px; color: #333; text-decoration: none; margin-bottom: 5px; border-radius: 4px; }
        .sidebar nav a.active, .sidebar nav a:hover { background: #e0f2f1; color: #00796b; }
        
        .content { flex: 1; padding: 30px; }
        
        /* Header & Stats */
        .events-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .events-header button { background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px; }
        .stat-icon { font-size: 24px; padding: 10px; border-radius: 50%; background: #f0f0f0; }
        .stat-content h3 { margin: 0; font-size: 14px; color: #666; }
        .stat-content p { margin: 5px 0 0; font-size: 24px; font-weight: bold; color: #333; }

        /* Event Cards Grid */
        .section-title { font-size: 18px; margin-bottom: 15px; color: #333; border-left: 4px solid #10b981; padding-left: 10px; }
        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .event-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border: 1px solid #eee; }
        .event-card h3 { margin-top: 0; color: #10b981; }
        .event-card p { color: #666; font-size: 14px; line-height: 1.5; }
        
        .no-data { grid-column: 1 / -1; color: #888; font-style: italic; }
    </style>
</head>
<body>

<header class="top-bar">
    <h1>EcoRewards</h1>
    <a href="logout.php" class="logout">Log out</a>
</header>

<div class="container">
    <aside class="sidebar">
        <nav>
            <a href="../partner/dashboard.php">Dashboard</a>
            <a href="../partner/marketing.php">Marketing Analysis</a>
            <a href="../partner/events/events.php" class="active">Events</a>
            <a href="../partner/rewards/rewards.php">Rewards</a>
            <a href="../partner/profile.php">Profile</a>
        </nav>
    </aside>

    <main class="content">
        
        <div class="events-container">
            <div class="events-header">
                <div>
                    <h1>Events Management</h1>
                    <p>Create and manage events for your users</p>
                </div>
                <button onclick="location.href='createEvent.php'">+ Create Event</button>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon purple">🎁</div>
                    <div class="stat-content">
                        <h3>Total Events</h3>
                        <p><?php echo $totalEvents; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">⏳</div>
                    <div class="stat-content">
                        <h3>Ongoing Events</h3>
                        <p><?php echo $ongoingCount; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">👥</div>
                    <div class="stat-content">
                        <h3>Total Participants</h3>
                        <p><?php echo $totalParticipants; ?></p>
                    </div>
                </div>
            </div>

            <h2 class="section-title">Ongoing Events (Today)</h2>
            <div class="events-grid" id="ongoingEventsList">
                <?php
                // Get events where date matches today
                $query = "SELECT * FROM tblevents WHERE event_date = CURDATE()"; 
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="event-card">
                                <h3>' . htmlspecialchars($row['event_title']) . '</h3>
                                <p><strong>Date:</strong> ' . $row['event_date'] . '</p>
                                <p>' . htmlspecialchars($row['event_desc']) . '</p>
                              </div>';
                    }
                } else {
                    echo '<p class="no-data">No ongoing events today.</p>';
                }
                ?>
            </div>

            <h2 class="section-title">Upcoming Events</h2>
            <div class="events-grid" id="upcomingEventsList">
                <?php
                // Get events in the future
                $query = "SELECT * FROM tblevents WHERE event_date > CURDATE() ORDER BY event_date ASC"; 
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="event-card">
                                <h3>' . htmlspecialchars($row['event_title']) . '</h3>
                                <p><strong>Date:</strong> ' . $row['event_date'] . '</p>
                                <p>' . htmlspecialchars($row['event_desc']) . '</p>
                              </div>';
                    }
                } else {
                    echo '<p class="no-data">No upcoming events found.</p>';
                }
                ?>
            </div>

            <div id="pastSection">
                <h2 class="section-title" style="color:#666; border-color:#ccc;">Past Events</h2>
                <div class="events-grid" id="pastEventsList">
                    <?php
                    // Get events from the past
                    $query = "SELECT * FROM tblevents WHERE event_date < CURDATE() ORDER BY event_date DESC"; 
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<div class="event-card" style="opacity: 0.7;">
                                    <h3 style="color:#666;">' . htmlspecialchars($row['event_title']) . '</h3>
                                    <p><strong>Date:</strong> ' . $row['event_date'] . '</p>
                                    <p>' . htmlspecialchars($row['event_desc']) . '</p>
                                  </div>';
                        }
                    } else {
                        echo '<p class="no-data">No past history found.</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>

<?php
// Close database connection at the very end
mysqli_close($conn);
?>