<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include "../config/dbcon.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

$monthlyQuery = "SELECT DATE_FORMAT(redemption_date, '%b %Y') as label, COUNT(id) as total 
                 FROM reward_redemption 
                 WHERE rewards_id IN (SELECT id FROM rewards WHERE partners_id = $partnerId)
                 GROUP BY label ORDER BY redemption_date ASC";
// Note: If you want event participation trends instead, use this:
$eventTrendQuery = "SELECT DATE_FORMAT(e.start_date, '%b %Y') as label, COUNT(l.id) as total 
                    FROM event_logs l 
                    JOIN events e ON l.events_id = e.id 
                    WHERE e.partners_id = $partnerId 
                    GROUP BY label ORDER BY e.start_date ASC";
$resTrend = mysqli_query($conn, $eventTrendQuery);
$monthlyLabels = []; $monthlyData = [];
while($row = mysqli_fetch_assoc($resTrend)) {
    $monthlyLabels[] = $row['label'];
    $monthlyData[] = $row['total'];
}

// 2. DAILY DATA (Added this)
$dailyQuery = "SELECT DATE_FORMAT(e.start_date, '%Y-%m-%d') as label, COUNT(l.id) as total 
               FROM event_logs l 
               JOIN events e ON l.events_id = e.id 
               WHERE e.partners_id = $partnerId 
               GROUP BY label ORDER BY e.start_date ASC";
$resDaily = mysqli_query($conn, $dailyQuery);
$dailyLabels = []; $dailyData = [];
while($row = mysqli_fetch_assoc($resDaily)) {
    $dailyLabels[] = $row['label'];
    $dailyData[] = $row['total'];
}

// 3. YEARLY DATA (Added this - Fixes your problem)
$yearlyQuery = "SELECT DATE_FORMAT(e.start_date, '%Y') as label, COUNT(l.id) as total 
                FROM event_logs l 
                JOIN events e ON l.events_id = e.id 
                WHERE e.partners_id = $partnerId 
                GROUP BY label ORDER BY label ASC";
$resYearly = mysqli_query($conn, $yearlyQuery);
$yearlyLabels = []; $yearlyData = [];
while($row = mysqli_fetch_assoc($resYearly)) {
    $yearlyLabels[] = $row['label'];
    $yearlyData[] = $row['total'];
}




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


<!DOCTYPE html>
<html>
<head>
    <title> Marketing Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-wrapper {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .chart-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .btn-filter {
            padding: 8px 16px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-filter.active {
            background: #1b7f4b;
            color: white;
            border-color: #1b7f4b;
        }
        .sec-title {
            font-size: 20px;
            margin: 30px 0 15px;
            color: #333;
        }
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
                $imagePath = "../img/" . $partner['name'] . ".png";
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
            <a href="partner_homepage.php" class="nav-item">Dashboard</a>
            <a href="marketing.php" class="nav-item active">Marketing Analysis</a>
            <a href="events/events.php" class="nav-item ">Events</a>
            <a href="rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="content">
        <header class="main-header">
            <div>
                <h1>Marketing Analysis</h1>
            </div>
                <a href="../auth/logout.php" class="btn" style="background-color: #ef4444; text-decoration: none; color: white;">Logout</a>
        </header>

    <h2 class="sec-title">📊 Participation Trends</h2>
        <div class="chart-wrapper">
            <div class="chart-controls">
                <button class="btn-filter" onclick="updateChart('daily')" id="btnDaily">Daily</button>
                <button class="btn-filter active" onclick="updateChart('monthly')" id="btnMonthly">Monthly</button>
                <button class="btn-filter" onclick="updateChart('yearly')" id="btnYearly">Yearly</button>
            </div>
            <canvas id="participationChart" height="100"></canvas>
        </div>

        <h2 class="sec-title">🏆 Top Popular Events</h2>
        <div class="grid-3">
            <?php while($row = mysqli_fetch_assoc($resTop)): ?>
                <div class="card" style="border-top: 4px solid #ff4757;">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <h1 style="margin: 10px 0; color:#333;"><?php echo $row['total']; ?></h1>
                    <p>Participants Joined</p>
                </div>
            <?php endwhile; ?>
        </div>

        <h2 class="sec-title">👥 Recent Joiners</h2>
        <div class="grid-3">
            <?php while($row = mysqli_fetch_assoc($resPart)): ?>
                <div class="card" style="border-top: 4px solid #1e90ff;">
                    <h3><?php echo htmlspecialchars($row['fullname']); ?></h3>
                    <p>Joined: <b><?php echo htmlspecialchars($row['event_name']); ?></b></p>
                </div>
            <?php endwhile; ?>
        </div>

    </main>
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
                borderColor: '#1b7f4b',
                backgroundColor: 'rgba(27, 127, 75, 0.1)',
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

