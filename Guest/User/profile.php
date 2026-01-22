<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$user = $conn->query("
    SELECT fullname, profile_image, user_points
    FROM users
    WHERE id = $user_id
")->fetch_assoc();

/* ===== MOCK COUNTS ===== */
$joinedEvents = 1;
$ecoForms = 2;

/* ===== ACHIEVEMENT CALC ===== */
$uncollected = 0;
if ($joinedEvents >= 1) $uncollected += 5;
if ($ecoForms >= 1) $uncollected += 5;
if ($ecoForms >= 2) $uncollected += 5;
if ($ecoForms >= 5) $uncollected += 10;

$profileImg = !empty($user['profile_image'])
    ? "../image/" . $user['profile_image']
    : "../image/default_profile.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
.app{
    width:100%;
    max-width:420px;
    min-height:100vh;
    background:#f4f4f4;
    margin:0 auto;
}

/* PROFILE HEADER */
.profile-header{
    text-align:center;
    padding:20px 10px;
    background:#b4dac9;
}
.profile-img{
    width:130px;
    height:130px;
    border-radius:50%;
    background:white;
    object-fit:cover;
    border:4px solid white;
}
.info{
    text-align:center;
    padding:15px;
}
.points{
    font-size:40px;
    margin:15px 0;
}

/* CARD STYLE */
.card{
    background:#fff;
    border-radius:12px;
    padding:15px;
    margin:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.reward-card{
    cursor:pointer;
}
.btn{
    padding:10px 15px;
    background:#54a582;
    color:white;
    border:none;
    border-radius:8px;
    cursor:not-allowed;
}  
.menu{
    display:none;
    position:absolute;
    top:60px;
    right:16px;
    background:#fff;
    width:180px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0, 0, 0, 0.2);
    z-index:9999;
}
.menu a{
    display:block;
    padding:12px;
    text-decoration:none;
    color:#000;
} 
</style>
</head>

<body>

<div class="app">

<!-- HEADER (SAME AS HOMEPAGE + BACK BUTTON) -->
<header class="header">
    <a href="homepage.php" class="back-btn"></a>
    <span class="logo">EcoRewards</span>
    <span class="menu-icon" onclick="toggleMenu()">☰</span>
</header>

<div id="menu" class="menu">
    <a href="#">Activity History</a>
    <a href="#">Edit Profile</a>
</div>

<!-- PROFILE -->
<div class="profile-header">
    <img src="<?= htmlspecialchars($profileImg) ?>" class="profile-img">
    <h3><?= htmlspecialchars($user['fullname']) ?></h3>
</div>

<div class="info">
    <p>You have collected</p>
    <div class="points"><?= $user['user_points'] ?> points</div>
    <h3>Achievement</h3>
</div>

<!-- ACHIEVEMENT BOX -->
<div class="card">
    <span><?= $uncollected ?> points haven’t collect !!!</span>
    <button class="btn" disabled>Collect All</button>
</div>

<!-- MY REWARDS -->
<div class="card reward-card" onclick="location.href='my_rewards.html'">
    <span>My Rewards</span>
    <span>›</span>
</div>

</div>

<script>
function toggleMenu(){
    document.getElementById("menu").classList.toggle("hidden");
}
</script>
</body>
</html>
