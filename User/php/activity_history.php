<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER ECO ACTION HISTORY */
$history = $conn->query("
    SELECT material_type, quantity, points_earned, created_at
    FROM eco_actions
    WHERE users_id = $user_id
      AND status = 'archived'
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Activity History</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
.app{
    width:100%;
    margin:0;
}
.header{
    position:relative;
    background:#54a582;
    height:60px;
}
.header-inner{
    max-width:100%;
    margin:auto;
    height: 60px;
    display:flex;
    align-items:center;
    padding:0 12px;
}
.logo-area{
    display:flex;
    align-items:center;
    gap:8px;
}
.logo-img{
    width:32px;
    height:32px;
    border-radius:50%;
    overflow:hidden;
}
.logo-img img{
    width:100%;
    height:100%;
    object-fit:contain;
}
.logo-text{
    color:#fff;
    font-weight:bold;
}
.back-btn{
    position:absolute;
    left:16px;
    top:50%;
    width:16px;
    height:16px;
    border-left:2px solid white;
    border-bottom:2px solid white;
    transform:translateY(-50%) rotate(45deg);
    cursor:pointer;
}
.history-list{
    padding:16px;
}

.history-item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    border-bottom:1px solid #ddd;
    padding:14px 0;
}

.history-left{
    max-width:75%;
}

.history-date{
    font-size:12px;
    color:#777;
    margin-bottom:4px;
}

.history-title{
    font-size:15px;
}

.history-points{
    font-weight:600;
    color:#54a582;
    font-size:14px;
}
</style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <a href="profile.php" class="back-btn" aria-label="Back"></a>
        <div class="logo-area">
            <div class="logo-img">
                <img src="../image/logo.png" alt="Logo">
            </div>
            <span class="logo">EcoRewards</span>
        </div>
    </div>
</header>

<div class="history-list">

<?php if ($history->num_rows > 0): ?>
    <?php while($h = $history->fetch_assoc()): ?>
        <div class="history-item">
            <div class="history-left">
                <div class="history-date">
                    <?= date("d M Y", strtotime($h['created_at'])) ?>
                </div>
                <div class="history-title">
                    <?= $h['quantity'] ?> <?= $h['material_type'] ?>
                </div>
            </div>
            <div class="history-points">
                +<?= $h['points_earned'] ?> points
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;color:#777;">No activity history found</p>
<?php endif; ?>

</div>

</body>
