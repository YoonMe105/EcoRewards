<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id  = $_SESSION['user_id'];
$event_id = intval($_GET['id']);

/* Get event */
$event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();
if (!$event) {
    die("Event not found");
}

/* Check if user already joined */
$check = $conn->query("
    SELECT * FROM event_logs
    WHERE users_id = $user_id AND events_id = $event_id
");

$joined = $check->num_rows > 0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= $event['name'] ?></title>
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
.event-img{
    width:100%;
    aspect-ratio:16/5;
    object-fit:cover;
    border-radius:12px;
}
.info-box{
    background:white;
    padding:8px;
    border-radius:12px;
    margin-bottom:10px;
    font-size:18px;
}
.intructions{
    background:white;
    padding:12px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
}
.small{
    font-size:15px;
    color:#666;
}
.popup{
    display:none;
}
.popup.show{
    display:flex;
}

@media(max-width:768px){
    .header-inner{max-width:420px}
    .app{max-width:420px}
    .event-img{aspect-ratio:16/9}
}

</style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <a href="homepage.php" class="back-btn" aria-label="Back"></a>
        <div class="logo-area">
            <div class="logo-img">
                <img src="../image/logo.png" alt="Logo">
            </div>
            <span class="logo">EcoRewards</span>
        </div>
    </div>
</header>

<div class="content">

<img src="../image/<?= $event['image'] ?>?v=<?= time() ?>" class="event-img">

<div class="info-box">
    <h2>
        <?= $event['name'] ?>
    </h2>
    <p class="small">
        <?= date("d M Y", strtotime($event['start_date'])) ?> - 
        <?= date("d M Y", strtotime($event['end_date'])) ?>
    </p>
    <p><?= $event['description'] ?></p>
</div>

<div class="info-box intructions">
    <b>Instructions</b>
    <p>Complete this event to earn eco reward points.</p>

    <?php if($event['status']=="active"): ?>
        <p>Answer all questions and submit to earn points.</p>
    <?php else: ?>
        <p>This event is not active.</p>
    <?php endif; ?>
</div>

<?php if($event['status']=="active" && !$joined): ?>
    <button class="common-btn" onclick="openPopup()">Join Event</button>

<?php elseif($joined): ?>
    <p style="text-align:center;color:green;">✔ You have joined this event</p>

<?php endif; ?>

<!-- ===== POPUP MODAL ===== -->
<div class="popup" id="joinPopup">
    <div class="popup-box">
        <p><b>Join this event?</b></p>
        <p>You will start the quiz for this event.</p>

        <button class="common-btn" onclick="confirmJoin()">Yes, Join</button>
        <button class="common-btn" style="background:#aaa" onclick="closePopup()">Cancel</button>
    </div>
</div>

<script>
function openPopup(){
    document.getElementById("joinPopup").classList.add("show");
}

function closePopup(){
    document.getElementById("joinPopup").classList.remove("show");
}

function confirmJoin(){
    window.location.href = "quiz.php?event_id=<?= $event_id ?>";
}
</script>
</body>
</html>