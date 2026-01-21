<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* EVENTS */
$eventsData = [];
$events = $conn->query("
    SELECT * FROM events
    ORDER BY FIELD(status,'past','active','upcoming')
");
while ($row = $events->fetch_assoc()) {
    $eventsData[] = $row;
}

/* LEADERBOARD */
$leaders = $conn->query("
    SELECT fullname, user_points
    FROM users
    ORDER BY user_points DESC
    LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EcoRewards | Homepage</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
/* ================= HEADER ================= */
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
    justify-content:space-between;
    padding:0 12px;
}
/* ===== MOBILE MENU ICON ===== */
.menu-toggle{
    display:none;
    font-size:22px;
    color:#fff;
    cursor:pointer;
}

/* ===== MOBILE SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:0;
    left:-260px;
    width:260px;
    height:100vh;
    background:#54a582;
    padding:20px;
    transition:.3s ease;
    z-index:9999;
}
.sidebar a{
    display:block;
    color:#fff;
    text-decoration:none;
    font-size:16px;
    margin:16px 0;
}

/* ===== MOBILE OVERLAY ===== */
.overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:none;
    z-index:9998;
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
.nav a{
    color:#fff;
    text-decoration:none;
    font-size:12px;
    margin-left:8px;
}

/* ================= PAGE ================= */
.app{
    width:100%;
    margin:0;
}

/* ================= HERO IMAGE ================= */
.hero img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}
/* ===== ECO IMAGE + TABLE CARD ===== */
.eco-card{
    position: relative;
    margin: 0px 0 40px 0;
    width:100%;
    aspect-ratio:16/6;   /* FIXED SIZE */
    overflow:hidden;
    background:#ddd;
}

/* Background image */
.eco-bg{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Dark gradient overlay for image */
.eco-card::after{
    content:"";
    position:absolute;
    inset:0;
    background: linear-gradient(
        90deg,
        rgba(0, 0, 0, 0.4) 0%,
        rgba(0, 0, 0, 0.05) 40%,
        rgba(0, 0, 0, 0) 70%
    );
    pointer-events: none;
}

.eco-content{
    position:absolute;
    top:50%;
    left:80px;
    transform:translateY(-50%);
    max-width:520px;
    color:#fff;
    padding:32px 36px;
    border-radius:16px;

    /* Glass effect */
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(8px);

    /* Accent */
    border-left: 4px solid #54a582;
}

/* Title */
.eco-content h2{
    margin:0 0 16px 0;
    font-size:32px;
    font-weight:700;
}

/* Text */
.eco-content p{
    margin:0 0 14px 0;
    font-size:16px;
    line-height:1.6;
    opacity:0.95;
}

.eco-btn{
    display:inline-block;
    margin-top:12px;
    padding:12px 26px;
    background:#54a582;
    color:#fff;
    text-decoration:none;
    border-radius:999px;
    font-weight:600;
    transition:.3s ease;
}

.eco-btn:hover{
    background:#3f8f6e;
    transform:translateY(-2px);
}

.eco-desc-mobile{
    display:none;
}


.eco-row:last-child{
    border-bottom: none;
}

/* ================= ECO ACTION POPUP ================= */

/* Overlay already OK, just ensure centering */
.popup{
    padding: 130px;
}

/* Popup container */
.popup-box{
    padding: 20px 28px;
    border-radius: 12px;
}

/* Title row */
.popup-box strong{
    font-size: 25px;
}

/* Close button */
.popup-box span{
    font-size: 18px;
}

/* Form spacing */
#ecoForm{
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px; /* MAIN spacing control */
}

/* Labels */
#ecoForm label{
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 4px;
    display: block;
}

/* Date input */
#ecoForm input[type="date"]{
    padding: 10px 12px;
    font-size: 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
}

/* Action type radios */
#ecoForm label input[type="radio"]{
    margin-right: 6px;
}

#ecoForm div label{
    font-weight: normal;
    margin-bottom: 6px;
    display: inline-flex;
    align-items: center;
}

/* Quantity row */
#ecoForm .qty-row,
#ecoForm div[style*="display:flex"]{
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Quantity buttons */
#ecoForm button[type="button"]{
    width: 34px;
    height: 34px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: #f5f5f5;
    font-size: 18px;
    cursor: pointer;
}

/* Quantity input */
#ecoForm input[type="number"]{
    width: 60px;
    height: 34px;
    text-align: center;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* File input */
#ecoForm input[type="file"]{
    margin-top: 4px;
    font-size: 13px;
}

/* File name display */
#fileName{
    font-size: 12px;
    color: #666;
    margin-top: -6px;
}

/* Submit button spacing */
#ecoForm .common-btn{
    margin-top: 20px;
    padding: 14px;
    font-size: 18px;
    border-radius: 12px;
}

/* Message text */
#ecoMsg{
    margin-top: 6px;
    min-height: 18px;
}


/* ================= EVENT SLIDER ================= */
.event-section{
    width:100%;
    margin: 20px 0 20px 0;
    position: relative;
}

.event-slider{
    width:100%;
    overflow:hidden;
}

.event-slide{
    display:flex;
    width:100%;
    height:300px;
    background:#fff;
    border-radius:0px;
    overflow:hidden;
    cursor:pointer;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    margin-bottom:0px;
}

/* LEFT IMAGE */
.event-image{
    width:40%;
    height:100%;
}
.event-image img{
    width:90%;
    height:100%;
    object-fit:cover;
    border-radius:12px;
    margin: 0px 20px 0px 50px;
}

/* RIGHT CONTENT */
.event-content{
    width:60%;
    padding:20px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.event-content h3{
    font-size:25px;
    margin:0 0 25px 0;
}

.event-status{
    font-size:15px;
    color:#54a582;
    font-weight:600;
    margin-bottom:5px;
}

.event-desc{
    font-size:15px;
    color:#555;
    line-height:1.5;
    margin-bottom:14px;
}

.event-cta{
    font-size:15px;
    font-weight:600;
    color:#54a582;
    margin-top:10px;
}

/* ===== FADE TRANSITION ===== */
.event-slider{
    position: relative;
    height: 300px;
    overflow: hidden;
}

.event-slide{
    position: absolute;
    inset: 0;
    display:flex;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.8s ease;
}

.event-slide.active{
    opacity: 1;
    pointer-events: auto;
}

.event-slider .arrow{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.35);
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    font-size: 22px;
}

.event-slider .arrow.left{
    left: 10px;
}

.event-slider .arrow.right{
    right: 10px;
}

@media(max-width:768px){

    /* KEEP DESKTOP LAYOUT */
    .event-slide{
        flex-direction: row;     
        height: 150px;   
        margin:0px;     
    }
    .event-slider{
        height: 150px; 
    }
    .event-section{
        padding: 10px 0;
    }
    .event-image{
        width: 45%;
        height: 100%;
    }

    .event-image img{
        width: 90%;
        height: 100%;
        margin: 0 10px;
        border-radius: 10px;
    }

    .event-content{
        width: 55%;
        padding: 12px;
    }

    .event-content h3{
        font-size: 16px;
        margin-bottom: 6px;
    }

    .event-status{
        font-size: 10px;
        margin-bottom: 4px;
    }

    .event-desc{
        font-size: 10px;
        line-height: 1.3;
    }

    .event-cta{
        font-size: 10px;
        margin-top: 4px;
    }

    .event-slider .arrow{
        position: absolute;
        width: 26px;
        height: 26px;
        font-size: 18px;
    }

    .event-slider .arrow.left{
        left: 6px;
    }

    .event-slider .arrow.right{
        right: 6px;
    }
    .recycle{
        margin-top:16px;
    }
    
}

/* ================= RECYCLE ================= */
.recycle{
    text-align:center;
    margin:40px 0 80px 0;
}
.recycle-row{
    display:flex;
    justify-content:space-between;
}
.recycle-item{
    width:26%;
}
.recycle-img{
    width:80%;
    aspect-ratio:1/1;
    border-radius:0;
    overflow:hidden;
    margin:0 auto 6px;
}
.recycle-img img{
    width:100%;
    height:100%;
    object-fit:contain;
}
.recycle h3{
    font-size:20px;   
    margin-bottom:50px;
}

/* ================= LEADERBOARD ================= */
.leaderboard-row{
    display:flex;
    justify-content:space-between;
    margin: 80px 10px;

}
.lb-card{
    width:32%;
    background:#fff;
    border-radius:12px;
    padding:25px 10px 14px;
    text-align:center;
    position:relative;
}
.lb-img{
    width:45px;
    height:45px;
    border-radius:50%;
    overflow:hidden;
    position:absolute;
    top:-20px;
    left:50%;
    transform:translateX(-50%);
}
.lb-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= REWARDS ================= */
.rewards{
    background:#54a582;
    padding:14px;
    border-radius:12px;
    margin-bottom:30px;
    margin-left: 10px;
    margin-right: 10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
    color: white;
}

@media(max-width:768px){
    .header-inner{max-width:420px}
    .app{max-width:420px}
    .hero{aspect-ratio:16/9}
    .event-section{
    margin: 0;
    position:relative;
    }  
    .slider-wrapper{
        height:200px; 
        margin-top:1px;
    }
    .slide{
        width:80%;
        height:160px
    }
    .slide-info{font-size:14px;}
    .nav{ display:none; }
    .menu-toggle{ display:block; }
    .recycle h3{
        font-size:14px;
        margin-bottom:20px;
    }
    .recycle{margin:20px 0 60px 0;}
    .recycle-row{
    font-size:10px;
    margin-top:30px;
    }
    .eco-card{
        position: relative;
        margin: 0;
        width:100%;
        aspect-ratio:16/8;   /* FIXED SIZE */
        overflow:hidden;
        background:#ddd;
    }
    .eco-desc-desktop{
        display:none;
    }
    .eco-desc-mobile{
        display:block;
    }
    .eco-content{
        backdrop-filter: blur(4px);
        top:50%;
        left:5px;
        transform:translateY(-50%);
        max-width:220px;
        padding:12px 16px;
    }
    .eco-content h2{
        font-size:13px;         
        margin-bottom:8px;
    }
    .eco-content p{
        font-size:10px; 
        line-height:1.4;
        margin-bottom:6px;
    }
    .eco-btn{
        padding:8px 18px;
        font-size:12px;
        border-radius:999px;
    }
    .lb-img{
        width:35px;
        height:35px;
    }
    .lb-card{
        font-size:12px;
    }
    .leaderboard-row{
        margin: 30px 10px;
    }
    /* ================= ECO ACTION POPUP FIX ================= */

/* Overlay */
.popup{
    padding: 16px;                 /* small margin on mobile */
    align-items: center;
}

/* Popup box */
.popup-box{
    width: 100%;
    max-width: 420px;
    padding: 24px 24px 28px;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.25);
}

/* Title row */
.popup-box strong{
    font-size: 22px;
}

/* Close button */
.popup-box span{
    font-size: 20px;
}

/* Form layout */
#ecoForm{
    margin-top: 18px;
    display: flex;
    flex-direction: column;
    gap: 18px;          /* MORE breathing space */
}

/* Labels */
#ecoForm label{
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 6px;
}

/* Date input */
#ecoForm input[type="date"]{
    width: 100%;
    padding: 12px 14px;
    font-size: 14px;
    border-radius: 10px;
}

/* Radio buttons */
#ecoForm div label{
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    margin-bottom: 8px;
}

/* Quantity row */
#ecoForm div[style*="display:flex"]{
    display: flex;
    align-items: center;
    gap: 14px;
}

/* Quantity buttons */
#ecoForm button[type="button"]{
    width: 36px;
    height: 36px;
    border-radius: 8px;
    font-size: 18px;
}

/* Quantity input */
#ecoForm input[type="number"]{
    width: 64px;
    height: 36px;
    font-size: 14px;
}

/* File input */
#ecoForm input[type="file"]{
    font-size: 13px;
}

/* File name text */
#fileName{
    font-size: 12px;
    color: #666;
    margin-top: 4px;
}

/* Submit button */
#ecoForm .common-btn{
    margin-top: 22px;
    padding: 14px;
    font-size: 16px;
    border-radius: 12px;
}

/* Message */
#ecoMsg{
    min-height: 20px;
    margin-top: 8px;
}

.popup-box{
        max-height: 80vh;     /* looks like a BOX, not a page */
        padding: 20px;
    }

    #ecoForm{
        gap: 5px;
    }

    #ecoForm label{
        font-size: 12px;
    }

    #ecoForm div label{
        font-size: 12px;
    }

    #ecoForm .common-btn{
        font-size: 12px;
    }
    /* Action type radios */
    #ecoForm label input[type="radio"]{
        margin-right: 3px;
    }
    #ecoForm div label{
        font-weight: normal;
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
    }
}
    
</style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <div class="logo-area">
            <div class="logo-img">
                <img src="../image/logo.png" alt="Logo">
            </div>
            <div class="logo-text">EcoRewards</div>
        </div>

        <!-- DESKTOP NAV -->
        <div class="nav">
            <a href="profile.php">Profile</a>
            <a href="../setting.html">Setting</a>
            <a href="../about_us.html">About Us</a>
        </div>

        <!-- MOBILE MENU ICON -->
        <div class="menu-toggle" onclick="openSidebar()">☰</div>
    </div>
</header>
<div class="sidebar" id="sidebar">
    <a href="profile.php">Profile</a>
    <a href="../setting.html">Setting</a>
    <a href="../about_us.html">About Us</a>
</div>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="eco-card">

    <!-- Background Image -->
    <img src="./image/hero.jpg?v=<?= filemtime("./image/hero.jpg") ?>" alt="Eco Image" class="eco-bg">

    <div class="eco-content">
    <h2>EcoRewards</h2>

    <div class="eco-desc-desktop">
        <p>
            EcoRewards is a digital sustainability platform developed exclusively
            for APU students and staff.
        </p>
        <p>
            The platform enables users to submit verified eco-friendly actions
            to earn eco points.
        </p>
        <p>
            Earned points can be redeemed for rewards offered within the application.
        </p>
        <p>
            Participation in campus eco events also contributes to additional
            point accumulation.
        </p>
    </div>

    <!-- SHORT DESCRIPTION (MOBILE ONLY) -->
    <div class="eco-desc-mobile">
        <p>
            A sustainability platform for APU students and staff.
        </p>
        <p>
            Submit eco actions, earn points, redeem rewards, and join campus events.
        </p>
    </div>

    <button class="eco-btn" onclick="openEcoPopup()">Start Eco Action</button>

</div>
</div>

<div class="app">
<!-- EVENT SLIDER (IMAGE LEFT + TEXT RIGHT) -->
<div class="event-section">
    <div class="event-slider" id="slider">

        <?php foreach($eventsData as $e): ?>
        <div class="event-slide"
             onclick="location.href='event.php?id=<?= $e['id'] ?>'">

            <!-- LEFT IMAGE -->
            <div class="event-image">
                <img src="../image/<?= $e['image'] ?>?v=<?= time() ?>" alt="Event">
            </div>

            <!-- RIGHT CONTENT -->
            <div class="event-content">
                <h3><?= $e['name'] ?></h3>
                <span class="event-status"><?= ucfirst($e['status']) ?> Event</span>
                <p class="event-desc">
                <?php
                    if ($e['status'] === 'upcoming') {
                    echo "Get ready to take part in this upcoming eco event and earn eco points while supporting sustainability on campus.";
                    } elseif ($e['status'] === 'active') {
                    echo "This eco event is currently ongoing. Join now to contribute, participate, and earn eco points.";
                    } else {
                    echo "This eco event has ended. Thank you to all participants who contributed to a greener campus.";
                    }
                ?>
                </p>
                <span class="event-cta">View Event →</span>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="arrow left" onclick="prevSlide()">‹</div>
        <div class="arrow right" onclick="nextSlide()">›</div>
    </div>
</div>

<!-- LEADERBOARD -->
<div class="leaderboard-row">
<?php
$rank = 1;
while($l = $leaders->fetch_assoc()):
    $rankImg = "../image/rank".$rank.".jpg";
?>
    <div class="lb-card">
        <div class="lb-img">
            <img src="<?= $rankImg ?>" alt="Rank <?= $rank ?>">
        </div>
        <b><?= $l['fullname'] ?></b><br>
        <?= $l['user_points'] ?> points
    </div>
<?php
$rank++;
endwhile;
?>
</div>

<!-- RECYCLE -->
<div class="recycle">
<h3>OUR RECYCLE CATEGORY</h3>
<div class="recycle-row">
    <div class="recycle-item"><div class="recycle-img"><img src="../image/plastic_bottel.jpg"></div>Plastic Bottle</div>
    <div class="recycle-item"><div class="recycle-img"><img src="../image/aluminum_can.jpg"></div>Aluminum Can</div>
    <div class="recycle-item"><div class="recycle-img"><img src="../image/glass.jpg"></div>Glass</div>
    <div class="recycle-item"><div class="recycle-img"><img src="../image/paper.jpg"></div>Paper</div>
</div>
</div>


<!-- REWARDS -->
<div class="rewards" onclick="location.href='rewards.html'">
    <span>Rewards</span>
    <span>›</span>
</div>
</div>

<!-- ECO ACTION POPUP -->
<div class="popup" id="ecoPopup" style="display:none;">
  <div class="popup-box" style="max-width:420px; text-align:left;">

    <div style="display:flex; justify-content:space-between; align-items:center;">
      <strong>Eco Action</strong>
      <span style="cursor:pointer;" onclick="closeEcoPopup()">✕</span>
    </div>

    <form id="ecoForm" enctype="multipart/form-data">

      <!-- DATE -->
      <label>Date of Action</label>
      <input type="date" name="action_date" required>

      <!-- ACTION TYPE -->
      <label>Action Type</label>
      <div>
        <label><input type="radio" name="material_type" value="Plastic Bottle" required> Plastic Item</label><br>
        <label><input type="radio" name="material_type" value="Paper"> Paper Bag / Box</label><br>
        <label><input type="radio" name="material_type" value="Aluminum Can"> Aluminum Can</label><br>
        <label><input type="radio" name="material_type" value="Glass"> Glass</label>
      </div>

      <!-- QUANTITY -->
      <label>Quantity</label>
      <div style="display:flex; gap:8px; align-items:center;">
        <button type="button" onclick="changeQty(-1)">−</button>
        <input type="number" id="qty" name="quantity" value="1" min="1" readonly>
        <button type="button" onclick="changeQty(1)">+</button>
      </div>

      <!-- UPLOAD -->
      <label>Upload Photo</label>
      <input type="file" name="image" accept="image/*" required onchange="showFileName(this)">
      <small id="fileName"></small>

      <button type="submit" class="common-btn">SUBMIT</button>
      <p id="ecoMsg" style="text-align:center;font-size:14px;"></p>

    </form>
  </div>
</div>

<script>
let current = 0;
const slides = document.querySelectorAll(".event-slide");
const total = slides.length;

function showSlide(index){
    slides.forEach((slide, i) => {
        slide.classList.toggle("active", i === index);
    });
}

function nextSlide(){
    current = (current + 1) % total;
    showSlide(current);
}

function prevSlide(){
    current = (current - 1 + total) % total;
    showSlide(current);
}

/* Init */
if (total > 0) {
    showSlide(0);
    setInterval(nextSlide, 5000); // auto change every 5s
}

/* Sidebar (unchanged) */
function openSidebar(){
    document.getElementById("sidebar").style.left = "0";
    document.getElementById("overlay").style.display = "block";
}
function closeSidebar(){
    document.getElementById("sidebar").style.left = "-260px";
    document.getElementById("overlay").style.display = "none";
}
function openEcoPopup(){
  document.getElementById("ecoPopup").style.display = "flex";
}

function closeEcoPopup(){
  document.getElementById("ecoPopup").style.display = "none";
}

function changeQty(val){
  const qty = document.getElementById("qty");
  let newVal = parseInt(qty.value) + val;
  if(newVal >= 1) qty.value = newVal;
}

function showFileName(input){
  document.getElementById("fileName").innerText = input.files[0].name;
}

/* SUBMIT FORM */
document.getElementById("ecoForm").addEventListener("submit", function(e){
  e.preventDefault();

  const formData = new FormData(this);

  fetch("submit_eco_action.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(msg => {
    document.getElementById("ecoMsg").innerText = msg;
    if(msg.includes("success")){
      setTimeout(() => location.reload(), 1500);
    }
  });
});
</script>
</body>
</html>
