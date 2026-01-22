<?php
require "db.php";

$error = "";
$success = "";

/* Change image names here only */
$SIDE_IMAGE = "../image/side.jpg?v=" . filemtime("../image/side.jpg"); 
$LOGO_IMAGE = "../image/logo.png";        // logo image

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    if ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match";
    } else {

        /* Check user exists */
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "Email not found";
        } else {

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashedPassword, $email);
            $update->execute();

            $success = "Password updated successfully";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">

<style>
/* ===== HEADER (WITH BACK ARROW) ===== */
.header{
    height:60px;
    background:#54a582;
    position:relative;
}
.header-inner{
    height:60px;
    display:flex;
    align-items:center;
    padding:0 12px;
}

/* ===== PAGE WRAPPER ===== */
.auth-shell{
    width:100%;
    padding:0 16px;
    margin:0 auto;
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
    margin:30px auto 10px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eee;
}

/* ✅ FIX: override global img{height:auto} ONLY here */
.logo-placeholder img{
    width:100% !important;
    height:100% !important;
    max-width:none !important;
    object-fit:contain;
    display:block;
    padding:0;
}

h2{
    text-align:center;
    margin-bottom:30px;
}

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
    margin-top:30px;
}

.error{
    color:red;
    text-align:center;
    margin-top:10px;
}
.success{
    color:green;
    text-align:center;
    margin-top:10px;
}

/* ===== DESKTOP (wireframe: left image box + right form) ===== */
@media (min-width:900px){
    .auth-page{
        display:flex;
        width:100%;
        height: calc(100vh - 60px);   /* ✅ fixed: no scrolling */
        overflow:hidden;              /* ✅ prevent page scroll from this section */
    }
    .auth-shell{
        padding: 0;
    }

    .side-image{
        display:block;
        flex:0.70;                 /* take left half */
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
        flex:1;
        display:flex;
        justify-content:center;
        padding:0;
        max-width:none;
        margin:0;
    }

    .form-box{
        width:420px;
        padding:20px 10px;
    }
}
</style>
</head>

<body>

<header class="header">
    <div class="header-inner">
        <a href="login.php" class="back-btn" aria-label="Back"></a>
    </div>
</header>

<div class="auth-shell">
    <div class="auth-page">

        <!-- LEFT IMAGE (DESKTOP ONLY) -->
        <div class="side-image">
            <img src="<?= htmlspecialchars($SIDE_IMAGE) ?>" alt="Reset Password Visual">
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
                    <label>New Password</label>
                    <input type="password" name="newPassword" required>
                    <label>Confirm Password</label>
                    <input type="password" name="confirmPassword" required>

                    <button type="submit">UPDATE</button>
                </form>

                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                    <script>
                        setTimeout(() => {
                            window.location.href = "login.php";
                        }, 1500);
                    </script>
                <?php endif; ?>

            </div>
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
