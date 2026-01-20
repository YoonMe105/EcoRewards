<?php
session_start();
if (!isset($_SESSION['partner'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../config/db.php";
$partnerId = $_SESSION['partner']['id'];

$monthlyQuery = "SELECT DATE_FORMAT(redemption_date, '%b %Y') as label, COUNT(id) as total 
                 FROM reward_redemption 
                 WHERE rewards_id IN (SELECT id FROM rewards WHERE partners_id = $partnerId)
                 GROUP BY label ORDER BY redemption_date ASC";
// Note: If you want event participation trends instead, use this:
$eventTrendQuery = "SELECT DATE_FORMAT(e.start_date, '%b') as label, COUNT(l.id) as total 
                    FROM event_logs l 
                    JOIN events e ON l.events_id = e.id 
                    WHERE e.partners_id = $partnerId 
                    GROUP BY label";

$resTrend = mysqli_query($conn, $eventTrendQuery);
$monthlyLabels = [];
$monthlyData = [];

while($row = mysqli_fetch_assoc($resTrend)) {
    $monthlyLabels[] = $row['label'];
    $monthlyData[] = $row['total'];
}

// --- DATA FOR CARDS ---

// Top 3 Popular Events
$resTop = mysqli_query($conn, "SELECT e.name, COUNT(l.id) as total 
                               FROM events e 
                               JOIN event_logs l ON e.id = l.events_id 
                               WHERE e.partners_id = $partnerId 
                               GROUP BY e.id ORDER BY total DESC LIMIT 3");

// Recent Joiners
$resPart = mysqli_query($conn, "SELECT u.fullname, e.name as event_name 
                                FROM event_logs l 
                                JOIN users u ON l.users_id = u.id 
                                JOIN events e ON l.events_id = e.id 
                                WHERE e.partners_id = $partnerId 
                                ORDER BY l.id DESC LIMIT 4");
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing Analysis</title>
    <link rel="stylesheet" href="assets/style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
     <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        /* Grid Layouts */
        .grid-3 { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        
        /* Card Styling */
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; font-size: 1.1rem; color: #444; }
        .card p { color: #666; font-size: 0.9rem; }
        
        /* Chart Section */
        .chart-wrapper { background: white; padding: 20px; border-radius: 12px; margin-bottom: 40px; }
        .chart-controls { text-align: right; margin-bottom: 15px; }
        .btn-filter { 
            padding: 8px 16px; border: none; background: #e4e6eb; cursor: pointer; border-radius: 6px; font-weight: bold;
        }
        .btn-filter.active { background: #007bff; color: white; }

        /* Section Titles */
        .sec-title { border-left: 5px solid #007bff; padding-left: 10px; margin: 30px 0 15px 0; color: #333;}
    </style>
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
            <a href="../partner/marketing.php" class="active">Marketing Analysis</a>
            <a href="../partner/events/events.php" >Events</a>
            <a href="../partner/rewards/rewards.php">Rewards</a>
            <a href="../partner/profile.php">Profile</a>
        </nav>
    </aside>

    <main class="content">
        <div class="main-header">
            <h1>Marketing Analysis</h1>
            <p>Analyze event participation trends and popular events.</p>
        </div>
    <h2 class="sec-title">📈 Participation Trends</h2>
    <div class="chart-wrapper">
        <div class="chart-controls">
            <button class="btn-filter" onclick="updateChart('daily')" id="btnDaily">Daily</button>
            <button class="btn-filter active" onclick="updateChart('monthly')" id="btnMonthly">Monthly</button>
            <button class="btn-filter" onclick="updateChart('yearly')" id="btnYearly">Yearly</button>
        </div>
        <canvas id="participationChart" height="100"></canvas>
    </div>

    <h2 class="sec-title">🔥 Top Popular Events</h2>
    <div class="grid-3">
        <?php while($row = mysqli_fetch_assoc($resTop)): ?>
            <div class="card" style="border-top: 4px solid #ff4757;">
                <h3><?php echo $row['name']; ?></h3>
                <h1 style="margin: 10px 0; color:#333;"><?php echo $row['total']; ?></h1>
                <p>Participants Joined</p>
            </div>
        <?php endwhile; ?>
    </div>

    
    </div>

    <h2 class="sec-title">👥 Recent Joiners</h2>
    <div class="grid-4">
        <?php while($row = mysqli_fetch_assoc($resPart)): ?>
            <div class="card" style="border-top: 4px solid #1e90ff;">
                <h3><?php echo $row['firstname'] . " " . $row['lastname']; ?></h3>
                <p>Joined: <b><?php echo $row['event_name']; ?></b></p>
            </div>
        <?php endwhile; ?>
    </div>

</div>

<script>
    // 1. PHP Data passed to JavaScript
    const dataDaily = { 
        labels: <?php echo json_encode($dailyLabels); ?>, 
        values: <?php echo json_encode($dailyData); ?> 
    };
    const dataMonthly = { 
        labels: <?php echo json_encode($monthlyLabels); ?>, 
        values: <?php echo json_encode($monthlyData); ?> 
    };
    const dataYearly = { 
        labels: <?php echo json_encode($yearlyLabels); ?>, 
        values: <?php echo json_encode($yearlyData); ?> 
    };

    // 2. Initialize Chart
    const ctx = document.getElementById('participationChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'line', // Line charts are best for time trends
        data: {
            labels: dataMonthly.labels, // Default to Monthly
            datasets: [{
                label: 'Participants Joined',
                data: dataMonthly.values,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3 // Makes line curvy
            }]
        },
        options: { responsive: true }
    });

    // 3. Function to Switch Data (The Filter Logic)
    function updateChart(period) {
        // Reset button styles
        document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
        
        let newData;
        if(period === 'daily') {
            newData = dataDaily;
            document.getElementById('btnDaily').classList.add('active');
        } else if(period === 'monthly') {
            newData = dataMonthly;
            document.getElementById('btnMonthly').classList.add('active');
        } else {
            newData = dataYearly;
            document.getElementById('btnYearly').classList.add('active');
        }

        // Update Chart
        myChart.data.labels = newData.labels;
        myChart.data.datasets[0].data = newData.values;
        myChart.update();
    }
</script>

</body>
</html>