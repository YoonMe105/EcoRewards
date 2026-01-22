<?php
require "db.php";

$error = "";

/* Change image names here only */
$SIDE_IMAGE = "./image/side.jpg?v=" . filemtime("./image/side.jpg");
$LOGO_IMAGE = "./image/logo.png";   // logo image

/* Already logged in */
if (isset($_SESSION['user_id'])) {
    header("Location: homepage.php");
    exit;
}

/* Handle login */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: homepage.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>EcoRewards | Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
/* ===== HEADER (BLANK COLOR BAR) ===== */
.header{
    height:60px;
    background:#54a582;
}

/* ===== MOBILE (default) ===== */
.auth-page{
    width:100%;
}

.side-image{ display:none; } /* mobile hidden */

.form-area{
    max-width:400px;
    margin:0 auto;
    padding:30px 20px;
}

.logo-placeholder{
    width:90px;
    height:90px;
    border-radius:50%;
    margin:20px auto 10px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eee;
}

/* ✅ Logo always fits the circle (override global img rules) */
.logo-placeholder img{
    width:100% !important;
    height:100% !important;
    max-width:none !important;
    max-height:none !important;
    object-fit:cover;        /* ✅ fill circle (removes whitespace around logo) */
    object-position:center;
    display:block;
    padding:0 !important;    /* ✅ no padding */
}


h2{
    text-align:center;
    margin-bottom:30px;
}

label{ font-size:14px; }
input{
    width:100%;
    padding:12px;
    margin:8px 0 16px;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    width:100%;
    padding:12px;
    background:#54a582;
    color:#fff;
    border:none;
    border-radius:8px;
    font-size:16px;
    margin-top:20px;
}

.forgot{ text-align:right; }
.forgot a{
    color:#54a582;
    text-decoration:none;
    font-size:14px;
}

.error{
    color:red;
    text-align:center;
    margin-top:10px;
    font-size:14px;
}

/* ===== DESKTOP (EXACT WIREFRAME: full left panel + right form) ===== */
@media (min-width:900px){
    .auth-page{
        display:flex;
        width:100%;
        height: calc(100vh - 60px);   /* ✅ fixed: no scrolling */
        overflow:hidden;              /* ✅ prevent page scroll from this section */
    }

    .side-image{
        display:block;
        flex:0.6;                 /* take left half */
        min-width:45%;
        background:#ddd;
        overflow:hidden;
    }

    /* ✅ Side image MUST fill the whole left panel */
    .side-image img{
        width:100% !important;
        height:100% !important;
        max-width:none !important;
        max-height:none !important;
        object-fit:cover;
        object-position:center;
        display:block;
    }

    .form-area{
        flex:1;                 /* right half */
        max-width:none;
        margin:0;
        padding:0;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#f5f5f5;
    }

    .form-box{
        width:420px;
        padding:30px 20px;
    }
}
</style>
</head>

<body>

<header class="header"></header>

<div class="auth-page">

    <!-- LEFT IMAGE (DESKTOP ONLY) -->
    <div class="side-image">
        <img src="<?= htmlspecialchars($SIDE_IMAGE) ?>" alt="Login Visual">
    </div>

    <!-- RIGHT FORM -->
    <div class="form-area">
        <div class="form-box">

            <div class="logo-placeholder">
                <img src="<?= htmlspecialchars($LOGO_IMAGE) ?>" alt="EcoRewards Logo">
            </div>

            <h2>EcoRewards</h2>

            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <p class="forgot">
                    <a href="forgot_password.php">Forgot password?</a>
                </p>

                <button type="submit">LOGIN</button>

                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
            </form>

        </div>
    </div>

</div>

</body>
<script>
    // refresh page every time it is loaded
    window.onload = function () {
        if (performance.navigation.type === 2) {
            location.reload(true);
        }
    };
</script>
</html>
