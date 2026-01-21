<?php

if (!isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    header("Location: ./User/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>

    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Profile</h1>
                    <p>Manage your account setting.</p>
                </div>
                
            </div>

            <div class="profile-card">

                <div class="profile-img">
                    <img src="./assets/img/admin.jpg" alt="Admin" class="adminprofile" />
                </div>

                <h3>Admin</h3>

                <div class="info">
                    <p><i class="fa fa-envelope"></i> admin@ecorewards.com</p>
                    <p><i class="fa fa-phone"></i> +60112898742</p>
                </div>

                <a href="edit-profile.php" class="edit-btn">Edit Profile</a>

            </div>

        </main>

    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    

</body>
</html>