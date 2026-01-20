<?php
session_start();
if (!isset($_SESSION['partners'])) {
    header("Location: login.php");
    exit();
}

include "../config/dbcon.php";
$partner = $_SESSION['partners'];
$partnerId = $partner['id'];

$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId"))['count'] ?? 0;
$totalParticipants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM event_logs WHERE events_id IN (SELECT id FROM events WHERE partners_id = $partnerId)"))['count'] ?? 0;
$activeEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE partners_id = $partnerId AND status = 'active'"))['count'] ?? 0;
$availableRewards = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM rewards WHERE partners_id = $partnerId AND status = 'available'"))['count'] ?? 0;
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
    <title>Partner Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo">EcoRewards</div>
        </div>

        <div class="profile">
            <div class="avatar">JD</div>
            <div class="profile-info">
                <div class="name"><?= htmlspecialchars($partner['name'] ?? 'Partner') ?></div>
                <div class="role">Partner</div>
            </div>
        </div>

        

        <nav class="nav">
            <a class="nav-item active" href="../partner/dashboard.php">Dashboard</a>
            <a class="nav-item" href="../partner/marketing.php">Marketing Analysis</a>
            <a class="nav-item" href="../partner/events/events.html">Events</a>
            <a class="nav-item" href="../partner/rewards/rewards.php">Rewards</a>
            <a class="nav-item" href="../partner/profile.php">Profile</a>
        </nav>

        <div class="sidebar-bottom">
            <a href="../auth/logout.php" class="logout">Logout</a>
        </div>
    </aside>

    <main class="main">
        <header class="main-header">
            <h1>Dashboard</h1>
            <p class="subtitle">Welcome back! Here's what's happening with your partnership.</p>
        </header>

        <section class="metrics">
            <div class="metric-card">
                <div class="metric-icon">👥</div>
                <div class="metric-label">Total Users Engaged</div>
                <div class="metric-value">1,243</div>
            </div>

            <div class="metric-card">
                <div class="metric-icon">📅</div>
                <div class="metric-label">Active Events</div>
                <div class="metric-value"><?= $eventCount ?></div>
            </div>

            <div class="metric-card">
                <div class="metric-icon">🎁</div>
                <div class="metric-label">Rewards Distributed</div>
                <div class="metric-value"><?= $rewardCount ?></div>
            </div>

            <div class="metric-card">
                <div class="metric-icon">📈</div>
                <div class="metric-label">Marketing Reach</div>
                <div class="metric-value">45.2K</div>
            </div>
        </section>

        <section class="quick-access">
            <h2>Quick Access</h2>
            <div class="quick-grid">
                <a class="quick-box" href="#">
                    <div class="qa-icon">📊</div>
                    <div class="qa-content">
                        <div class="qa-title">Marketing Analysis</div>
                        <div class="qa-sub">View detailed analytics and insights</div>
                    </div>
                </a>

                <a class="quick-box" href="../partner/events.html">
                    <div class="qa-icon">📅</div>
                    <div class="qa-content">
                        <div class="qa-title">Events</div>
                        <div class="qa-sub">Manage and track your events</div>
                    </div>
                </a>

                <a class="quick-box" href="rewards.php">
                    <div class="qa-icon">🎁</div>
                    <div class="qa-content">
                        <div class="qa-title">Rewards</div>
                        <div class="qa-sub">Manage reward programs</div>
                    </div>
                </a>
            </div>
        </section>

        <section class="recent">
            <h2>Recent Activity</h2>
            <div class="recent-list">
                <?php
                $recentEvents = [];
                $res = mysqli_query($conn, "SELECT id, title, created_at FROM events WHERE partners_id={$partner['id']} ORDER BY created_at DESC LIMIT 5");
                if ($res) {
                    while ($r = mysqli_fetch_assoc($res)) {
                        $recentEvents[] = $r;
                    }
                }

                if (count($recentEvents) === 0) : ?>
                    <div class="recent-item">
                        <div class="dot"></div>
                        <div class="text">No recent activity yet. Create your first event!</div>
                    </div>
                <?php else:
                    foreach ($recentEvents as $ev): ?>
                        <div class="recent-item">
                            <div class="dot green"></div>
                            <div class="text"><?= htmlspecialchars($ev['title']) ?><div class="muted"><?= date('M j, Y', strtotime($ev['created_at'] ?? 'now')) ?></div></div>
                        </div>
                    <?php endforeach;
                endif;
                ?>
            </div>
        </section>
    </main>
</div>

</body>
</html>

<!-- //console - debugging (week 5 lecture) -->