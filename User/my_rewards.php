<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$rewards = $conn->query("
    SELECT rr.id, r.name
    FROM reward_redemption rr
    JOIN rewards r ON rr.rewards_id = r.id
    WHERE rr.users_id = $user_id
      AND rr.status = 'unused'
    ORDER BY rr.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Rewards</title>
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
.reward-card{
    margin:14px;
    padding:16px;
    background:#fff;
    border-radius:8px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.reward-card button{
    background:#54a582;
    color:white;
    border:none;
    padding:6px 14px;
    border-radius:6px;
    cursor:pointer;
}

/* POPUP */
.popup{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:flex;
    justify-content:center;
    align-items:center;
}

.popup-box{
    background:#fff;
    padding:20px;
    width:85%;
    max-width:320px;
    border-radius:8px;
    text-align:center;
}

.popup-box button{
    margin:10px;
    padding:8px 20px;
    border-radius:6px;
    border:none;
}

.confirm{ background:#54a582; color:#fff; }
.cancel{ background:#ccc; }

.hidden{ display:none; }
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

<!-- REWARDS LIST -->
<?php if ($rewards->num_rows > 0): ?>
    <?php while($r = $rewards->fetch_assoc()): ?>
        <div class="reward-card">
            <div>
                <strong><?= $r['name'] ?></strong><br>
                <small>All shops in APU</small>
            </div>
            <button onclick="openPopup(<?= $r['id'] ?>, this)">Use</button>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p style="text-align:center;color:#777;margin-top:30px;">
        No rewards redeemed yet
    </p>
<?php endif; ?>

<!-- CONFIRM POPUP -->
<div id="redeemPopup" class="popup hidden">
  <div class="popup-box">
    <p>Confirm use this voucher?</p>
    <button class="confirm" onclick="confirmUse()">Confirm</button>
    <button class="cancel" onclick="closePopup()">Cancel</button>
  </div>
</div>

<!-- VOUCHER CODE POPUP -->
<div id="voucherPopup" class="popup hidden">
  <div class="popup-box">
    <p>Your Voucher Code</p>
    <h3 id="voucherCode"></h3>
    <button class="confirm" onclick="closeVoucherPopup()">OK</button>
  </div>
</div>

<script>
let selectedRewardId = null;
let selectedCard = null;

function openPopup(id, btn){
    selectedRewardId = id;
    selectedCard = btn.closest(".reward-card");
    document.getElementById("redeemPopup").classList.remove("hidden");
}

function closePopup(){
    document.getElementById("redeemPopup").classList.add("hidden");
}

function confirmUse(){
    closePopup();

    fetch("use_reward.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "reward_id=" + selectedRewardId
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            // remove card immediately
            selectedCard.remove();

            // show voucher popup
            const code = "ECO-" + selectedRewardId + "-" + new Date().getFullYear();
            document.getElementById("voucherCode").innerText = code;
            document.getElementById("voucherPopup").classList.remove("hidden");
        }
    });
}

function closeVoucherPopup(){
    document.getElementById("voucherPopup").classList.add("hidden");
}
</script>

</body>
</html>
