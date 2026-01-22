<?php
require "db.php";

/* User must be logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['user_id'];
    $newPhoneNo = trim($_POST['newPhoneNo']);

    if (empty($newPhoneNo)) {
        $error = "Phone number cannot be empty.";
    } else {

        $stmt = $conn->prepare("UPDATE users SET phone = ? WHERE id = ?");
        $stmt->bind_param("si", $newPhoneNo, $userId);

        if ($stmt->execute()) {
            $success = "Phone number updated successfully.";
        } else {
            $error = "Failed to update phone number.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EcoRewards | Change Phone Number</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
/* ===== SAME AS change_pass.php ===== */

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
    height:60px;
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

/* ===== CONTENT ===== */
.content{
    padding:20px;
}

label{
    font-size:14px;
}

input{
    width:100%;
    padding:12px;
    margin:8px 0 16px;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    margin-top:440px;
    width:100%;
    padding:12px;
    background:#54a582;
    color:white;
    border:none;
    border-radius:12px;
    font-size:16px;
    cursor:pointer;
}

.error{
    color:red;
    text-align:center;
    margin-top:10px;
    font-size:14px;
}

.success{
    color:green;
    text-align:center;
    margin-top:10px;
    font-size:14px;
}

@media(max-width:768px){
    button{
        margin-top:270px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <a href="../setting.html" class="back-btn" aria-label="Back"></a>
        <div class="logo-area">
            <div class="logo-img">
                <img src="../image/logo.png" alt="Logo">
            </div>
            <span class="logo-text">EcoRewards</span>
        </div>
    </div>
</header>

<!-- CONTENT -->
<div class="content">

    <form method="POST">

        <label>New Phone Number</label>
        <input type="text" name="newPhoneNo" placeholder="Enter new phone number">

        <button type="submit">UPDATE</button>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
            <script>
                setTimeout(() => {
                    window.location.href = "../setting.html";
                }, 1500);
            </script>
        <?php endif; ?>

    </form>

</div>

</body>
</html>
