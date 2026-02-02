<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$user = $conn->query("
    SELECT user_points 
    FROM users 
    WHERE id = $user_id
")->fetch_assoc();

$rewards = $conn->query("
    SELECT *
    FROM rewards
    WHERE status = 'available'
      AND quantity > 0
      AND (expired_at IS NULL OR expired_at > NOW())
    ORDER BY points_required ASC
");

if (isset($_POST['redeem_reward'])) {

    $reward_id = (int)$_POST['reward_id'];

    $reward = $conn->query("
        SELECT * FROM rewards 
        WHERE id = $reward_id
        LIMIT 1
    ")->fetch_assoc();

    if ($reward && $user['user_points'] >= $reward['points_required']) {

        $conn->query("
            UPDATE users 
            SET user_points = user_points - {$reward['points_required']}
            WHERE id = $user_id
        ");

        $conn->query("
            UPDATE rewards 
            SET quantity = quantity - 1
            WHERE id = $reward_id
        ");

        $conn->query("
            INSERT INTO reward_redemption (users_id, rewards_id, status, redemption_date)
            VALUES ($user_id, $reward_id, 'unused', NOW())
        ");

        echo "<script>
            window.onload = function(){
                document.getElementById('successPopup').classList.remove('hidden');
            }
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rewards</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* RESET */
html, body{
    margin:0;
    padding:0;
    width:100%;
    background:#f4f6f5;
    font-family:Arial;
}

/* HEADER */
.header{
    height:60px;
    background:#54a582;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
}
.header-inner{
    width:100%;
    display:flex;
    align-items:center;
}
.back-btn{
    position:absolute;
    left:16px;
    top:50%;
    width:16px;
    height:16px;
    border-left:2px solid #fff;
    border-bottom:2px solid #fff;
    transform:translateY(-50%) rotate(45deg);
}
.logo-area{
    margin:auto;
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

/* LIST — FULL WIDTH ALWAYS */
.reward-list{
    width:100%;
    margin:0;
    padding:0;
}

/* CARD — EDGE TO EDGE */
.reward-card{
    margin:14px;
    padding:16px;
    background:#fff;
    border-radius:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* CONTENT */
.reward-info{
    flex:1;
}
.reward-info b{
    font-size:16px;
}
.reward-info small{
    display:block;
    color:#666;
    margin-top:4px;
    font-size:13px;
}

.reward-right{
    text-align:right;
    min-width:90px;
}
.points{
    font-weight:bold;
    margin-bottom:6px;
}

/* BUTTON */
.redeem-btn{
    background:#54a582;
    color:#fff;
    border:none;
    padding:6px 14px;
    border-radius:6px;
    cursor:pointer;
}
.redeem-btn.disabled{
    background:#ccc;
    cursor:not-allowed;
}

/* POPUPS */
.popup{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:999;
}
.popup-box{
    background:#fff;
    padding:24px;
    width:85%;
    max-width:320px;
    border-radius:12px;
    text-align:center;
}
.popup-box button{
    margin-top:14px;
    padding:8px 20px;
    border:none;
    border-radius:6px;
}
.confirm{background:#54a582;color:#fff;}
.hidden{display:none;}

/* STACK BUTTONS ON SMALL SCREENS */
@media(max-width:480px){
    .reward-card{
        flex-direction:column;
        align-items:flex-start;
    }
    .reward-right{
        width:100%;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:10px;
    }
}
</style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <a href="homepage.php" class="back-btn"></a>
        <div class="logo-area">
            <div class="logo-img">
                <img src="../image/logo.png">
            </div>
            <span>EcoRewards</span>
        </div>
    </div>
</header>

<div class="reward-list">

<?php while($r = $rewards->fetch_assoc()): ?>
<div class="reward-card">

    <div class="reward-info">
        <b><?= $r['name'] ?></b>
        <small><?= $r['description'] ?></small>
    </div>

    <div class="reward-right">
        <div class="points"><?= $r['points_required'] ?> pts</div>
        <?php if ($user['user_points'] >= $r['points_required']): ?>
            <button class="redeem-btn" onclick="openConfirm(<?= $r['id'] ?>)">Redeem</button>
        <?php else: ?>
            <button class="redeem-btn disabled">Not enough</button>
        <?php endif; ?>
    </div>

</div>
<?php endwhile; ?>

</div>

<!-- CONFIRM POPUP -->
<div id="confirmPopup" class="popup hidden">
  <div class="popup-box">
    <p>Confirm redeem reward?</p>
    <form method="post">
        <input type="hidden" name="reward_id" id="rewardId">
        <button class="confirm" name="redeem_reward">Confirm</button>
        <button type="button" onclick="closeConfirm()">Cancel</button>
    </form>
  </div>
</div>

<!-- SUCCESS POPUP -->
<div id="successPopup" class="popup hidden">
  <div class="popup-box">
    <p>Reward redeemed successfully!</p>
    <button class="confirm" onclick="closeSuccess()">OK</button>
  </div>
</div>

<script>
function openConfirm(id){
    document.getElementById("rewardId").value = id;
    document.getElementById("confirmPopup").classList.remove("hidden");
}
function closeConfirm(){
    document.getElementById("confirmPopup").classList.add("hidden");
}
function closeSuccess(){
    document.getElementById("successPopup").classList.add("hidden");
}
</script>

</body>
</html>
