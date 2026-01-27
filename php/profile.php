<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ================= USER DATA ================= */
$user = $conn->query("
    SELECT fullname, email, phone, user_points, profile_image
    FROM users WHERE id = $user_id
")->fetch_assoc();

$profileImg = "../image/default.png";

if (!empty($user['profile_image'])) {
    $imgPath = "../image/" . $user['profile_image'];
    if (file_exists($imgPath)) {
        $profileImg = $imgPath;
    }
}


/* ================= ACHIEVEMENTS ================= */
$achievements = [
    ["Join 1 Eco Event",5],
    ["Submit 1 Eco Action",5],
    ["Recycle 1 Plastic",5],
    ["Recycle 1 Paper",5]
];

$totalAchievementPoints = 0;
foreach ($achievements as $a) {
    $totalAchievementPoints += $a[1];
}

/* COLLECT ACHIEVEMENT (ONCE ONLY) */
if (isset($_POST['collect_points']) && empty($_SESSION['achievement_collected'])) {
    $conn->query("
        UPDATE users
        SET user_points = user_points + $totalAchievementPoints
        WHERE id = $user_id
    ");
    $_SESSION['achievement_collected'] = true;
    header("Location: profile.php");
    exit;
}

/* ================= UPDATE PROFILE ================= */
if (isset($_POST['update_profile'])) {

    if (!empty($_POST['username'])) {
        $newName = $conn->real_escape_string($_POST['username']);
        $conn->query("
            UPDATE users SET fullname='$newName'
            WHERE id=$user_id
        ");
    }
}
    /* ================= UPDATE PROFILE ================= */
if (isset($_POST['update_profile'])) {

    // Update username
    if (!empty($_POST['username'])) {
        $newName = $conn->real_escape_string($_POST['username']);
        $conn->query("
            UPDATE users 
            SET fullname='$newName'
            WHERE id=$user_id
        ");
    }

    // Update profile image
    if (!empty($_FILES['profile_image']['name'])) {

        $targetDir = "../image/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imgName = time() . "_" . basename($_FILES['profile_image']['name']);
        $targetPath = $targetDir . $imgName;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            $conn->query("
                UPDATE users 
                SET profile_image='$imgName'
                WHERE id=$user_id
            ");
        }
    }

    header("Location: profile.php");
    exit;
}

/* ================= USER REDEEMED REWARDS ================= */
$rewards = $conn->query("
    SELECT r.name
    FROM reward_redemption rr
    JOIN rewards r ON rr.rewards_id = r.id
    WHERE rr.users_id = $user_id
      AND rr.status = 'unused'
    ORDER BY rr.id DESC
    LIMIT 3
");
$hasRewards = $rewards->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EcoRewards | Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f5;
    overflow-x:hidden;
}

/* HEADER */
.header{
    background:#54a582;
    height:60px
}
.header-inner{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 16px;
    color:#fff;
}
.logo-area{
    display:flex;
    align-items:center;
    gap:8px
}
.logo-img{
    width:32px;
    height:32px;
    border-radius:50%;
    overflow:hidden
}
.logo-img img{
    width:100%;
    height:100%;
    object-fit:contain
}
.nav a{
    color:#fff;
    margin-left:12px;
    text-decoration:none;
    font-size:14px
}
.menu-toggle{
    display:none;
    font-size:22px;
    cursor:pointer}

/* SIDEBAR */
.sidebar{
    position:fixed;
    top:0;
    left:-260px;
    width:260px;
    height:100%;
    background:#54a582;
    padding:20px;
    transition:.3s;
    z-index:999
}
.sidebar a{
    color:#fff;
    text-decoration:none;
    display:block;
    margin:16px 0
}
.overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:none;
    z-index:998
}

/* COVER */
.cover{
    width:100%;
    height:300px;
    overflow:hidden;
    background:#ddd
}
.cover img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block
}

/* PROFILE */
.profile{
    display:flex;
    gap:20px;
    padding:20px;
    align-items:center;
    background-color:white;
}
.profile img{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    background:#ccc;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:20px;
    padding:20px;
}
.box{
    background:#fff;
    padding:20px;
    border-radius:8px;
}
.center{
    text-align:center;
    font-size:17px
}
.points{
    font-size:40px;
    margin:40px 0;
}

/* BUTTON */
.btn{
    background:#54a582;
    color:#fff;
    border:none;
    padding:10px 14px;
    border-radius:6px;
    cursor:pointer
}

/* MY REWARDS */
.rewards-box{
    position:relative
}
.view-all{
    position:absolute;
    right:20px;
    bottom:20px;
    text-decoration:none;
    font-size:14px
}

.popup{
    display:none;               /* THIS HIDES IT */
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    align-items:center;
    justify-content:center;
    z-index:9999;
}

.popup-box{
    background:#fff;
    padding:32px;
    width:320px;
    border-radius:16px;
    position:relative;
    text-align:center;
}

.popup-box label{
    display:block;
    margin-top:18px;
    margin-bottom:6px;
    font-weight:600;
    text-align:left;
}

.popup-box input[type="text"]{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
}

.popup-box input[type="file"]{
    display:none;
}

.popup-box .file-circle{
    width:140px;
    height:140px;
    border-radius:50%;
    border:2px dashed #aaa;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:12px auto 24px;
    cursor:pointer;
    font-weight:600;
    color:#555;
}

.popup-box .btn{
    margin-top:24px;
    width:100%;
}

.close{
    position:absolute;
    top:14px;
    right:16px;
    font-size:18px;
    cursor:pointer;
}
.achievement-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:8px;
}

.achievement-status{
    font-size:12px;
    color:#3f8f6e;
    background:#e7f5ee;
    padding:3px 8px;
    border-radius:999px;
    font-weight:600;
}

/* MOBILE */
@media(max-width:768px){
    .nav{display:none}
    .menu-toggle{display:block}
    .grid{grid-template-columns:1fr}
    .profile{flex-direction:column;text-align:center}
}
</style>
</head>

<body>

<header class="header">
<div class="header-inner">
    <div class="logo-area">
        <div class="logo-img">
            <img src="../image/logo.png">
        </div>
        <b>EcoRewards</b>
    </div>

    <div class="nav">
        <a href="homepage.php">Home</a>
        <a href="activity_history.php">Activity History</a>
        <a href="#" onclick="openPopup()">Edit Profile</a>
    </div>

    <div class="menu-toggle" onclick="openSidebar()">☰</div>
</div>
</header>

<div class="sidebar" id="sidebar">
    <a href="homepage.php">Home</a>
    <a href="activity_history.php">Activity History</a>
    <a href="#" onclick="openPopup()">Edit Profile</a>
</div>
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="cover">
    <img src="../image/profile_banner.jpg">
</div>

<div class="profile">
    <img src="<?= $profileImg ?>">
    <div>
        <h2><?= $user['fullname'] ?></h2>
        <p><?= $user['email'] ?></p>
        <p><?= $user['phone'] ?></p>
    </div>
</div>

<div class="grid">

<!-- ACHIEVEMENT -->
<div class="box">
<h3>Achievement:</h3>
<?php foreach($achievements as $a): ?> <!-- check if collected -->
    <div class="achievement-row">
        <div>
            <?= $a[0] ?> <b>+<?= $a[1] ?></b>
        </div>

        <?php if (!empty($_SESSION['achievement_collected'])): ?>
            <span class="achievement-status">Collected</span>
        <?php endif; ?>
    </div>
<?php endforeach; ?>


<?php if (empty($_SESSION['achievement_collected'])): ?>
<form method="post">
<button class="btn" name="collect_points">Collect</button>
</form>
<?php endif; ?>
</div>

<!-- TOTAL POINTS -->
<div class="box center">
<h3>Total Points:</h3>
<div class="points"><?= $user['user_points'] ?> points</div>
</div>

<!-- MY REWARDS -->
<div class="box rewards-box">
<h3>My Rewards:</h3>

<?php if ($hasRewards): ?>
    <?php while($r = $rewards->fetch_assoc()): ?>
        <p><?= $r['name'] ?></p>
    <?php endwhile; ?>
<?php else: ?>
    <p>You have no rewards</p>
<?php endif; ?>

<a href="my_rewards.php" class="view-all">View All ›</a>
</div>

</div>

<div class="popup" id="popup">
    <div class="popup-box">

        <span class="close" onclick="closePopup()">✕</span>

        <form method="post" enctype="multipart/form-data">

            <label>Profile Image</label>

            <label class="file-circle">
                <img id="previewImg" src="<?= $profileImg ?>" style="
                    width:100%;
                    height:100%;
                    object-fit:cover;
                    border-radius:50%;
                    display:block;
                ">
                <input type="file" name="profile_image" accept="image/*" onchange="previewProfile(this)">
            </label>


            <label>Change Username</label>
            <input type="text" name="username" placeholder="Leave empty to keep same">

            <button class="btn" name="update_profile">Save</button>

        </form>
    </div>
</div>


<script>
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const popup = document.getElementById("popup");

function openSidebar(){
    sidebar.style.left="0";
    overlay.style.display="block";
}
function closeSidebar(){
    sidebar.style.left="-260px";
    overlay.style.display="none";
}
function openPopup(){ popup.style.display="flex"; }
function closePopup(){ popup.style.display="none"; }
function previewProfile(input){
    if(input.files && input.files[0]){
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById("previewImg").src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>
