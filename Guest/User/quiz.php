<?php
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id  = $_SESSION['user_id'];
$event_id = intval($_GET['event_id'] ?? 0);

/* ===== HARD-CODED QUESTIONS ===== */
$questions = [
    1 => [
        "q" => "Which action helps reduce plastic waste?",
        "options" => [
            "Using single-use plastic bags",
            "Recycling plastic bottles",
            "Throwing plastic into rivers",
            "Burning plastic waste"
        ],
        "answer" => 1
    ],
    2 => [
        "q" => "Which item is recyclable in our System?",
        "options" => [
            "Used tissue paper",
            "Food waste",
            "Aluminium cans",
            "Styrofoam boxes"
        ],
        "answer" => 2
    ],
    3 => [
        "q" => "What is the best way to save electricity?",
        "options" => [
            "Leaving lights on all day",
            "Using energy-saving bulbs",
            "Opening the fridge frequently",
            "Charging devices overnight"
        ],
        "answer" => 1
    ],
    4 => [
        "q" => "Which practice is eco-friendly?",
        "options" => [
            "Using disposable cutlery",
            "Bringing your own shopping bag",
            "Wasting water while brushing teeth",
            "Throwing batteries into trash"
        ],
        "answer" => 1
    ],
    5 => [
        "q" => "Why should we plant trees?",
        "options" => [
            "They increase air pollution",
            "They reduce oxygen",
            "They help absorb carbon dioxide",
            "They cause soil erosion"
        ],
        "answer" => 2
    ]
];

$resultMsg = "";
$showPopup = false;
$isSuccess = false;

/* ===== HANDLE SUBMISSION ===== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $score = 0;
    $unanswered = false;

    foreach ($questions as $index => $q) {
        if (!isset($_POST["q$index"])) {
            $unanswered = true;
            break;
        }

        if ($_POST["q$index"] == $q['answer']) {
            $score += 5;
        }
    }

    if ($unanswered) {
        $resultMsg = "Please answer all questions before submitting.";
        $showPopup = true;
        $isSuccess = false;
    } else {
        $update = $conn->query("
            UPDATE users
            SET user_points = IFNULL(user_points, 0) + $score
            WHERE id = $user_id
        ");

        if ($update && $conn->affected_rows > 0) {
            $resultMsg = "You have submitted all the questions!<br>
                          Total points you get: <b>$score pts</b>";
            $isSuccess = true;
        } else {
            $resultMsg = "Something went wrong while updating your points.";
            $isSuccess = false;
        }

        $showPopup = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Eco Quiz</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
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
.quiz-box{
    background:white;
    padding:15px;
    border-radius:12px;
    margin-bottom:15px;
}

.quiz-box p{
    font-weight:bold;
}

.option{
    margin:6px 0;
}

.popup{
    display:none;
}
.popup.show{
    display:flex;
}
.popup-box{
    position:relative;
}
.close-btn{
    position:absolute;
    right:10px;
    top:8px;
    font-size:18px;
    cursor:pointer;
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

<form method="POST">

<?php foreach ($questions as $index => $q): ?>
<div class="quiz-box">
    <p><?= $index ?>. <?= $q['q'] ?></p>

    <?php foreach ($q['options'] as $optIndex => $opt): ?>
    <div class="option">
        <label>
            <input type="radio" name="q<?= $index ?>" value="<?= $optIndex ?>">
            <?= $opt ?>
        </label>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>

<button type="submit" class="common-btn">Submit</button>

</form>

</div>

<!-- ===== RESULT POPUP ===== -->
<div class="popup <?= $showPopup ? 'show' : '' ?>" id="resultPopup">
    <div class="popup-box">
        <?php if($isSuccess): ?>
            <span class="close-btn" onclick="goHome()">✖</span>
        <?php else: ?>
            <span class="close-btn" onclick="closePopup()">✖</span>
        <?php endif; ?>

        <p><?= $resultMsg ?></p>
    </div>
</div>

<script>
function closePopup(){
    document.getElementById("resultPopup").style.display = "none";
}

/* 🔑 FORCE REFRESH HOME */
function goHome(){
    window.location.href = "homepage.php?refresh=1";
}
</script>

</body>
</html>
