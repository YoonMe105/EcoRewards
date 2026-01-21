<?php

    session_start();

    include 'conn.php';

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../User/login.php");
        exit;
    }

    $id = $_SESSION['admin_id'];
    $error = "";
    $success = "";

    $sql = "SELECT *
            FROM admins
            WHERE id = $id
            LIMIT 1";

    $result = mysqli_query($dbConn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
    }


    // Update profile password
    if (isset($_POST['changePassword'])) {

        $current = $_POST['currentpassword'];
        $new     = $_POST['newpassword'];
        $confirm = $_POST['confirmpassword'];

        // Fetch current hashed password from DB
        $result = mysqli_query($dbConn, "SELECT password FROM admins WHERE id=$id");
        $row = mysqli_fetch_assoc($result);

        // Verify current password
        if (!password_verify($current, $row['password'])) {
            $error = "Current password is incorrect.";
        } elseif ($new !== $confirm) {
            $error = "New password and confirm password do not match.";
        } else {
            // Hash the new password before saving
            $newHash = password_hash($new, PASSWORD_DEFAULT);

            $sql = "UPDATE admins SET password='$newHash' WHERE id=$id";
            if (mysqli_query($dbConn, $sql)) {
                $success = "Password changed successfully!";
            } else {
                $error = "Error updating password: " . mysqli_error($dbConn);
            }
        }
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

            <div class="profile-container">
                <div class="profile-card">
                    <div class="profile-img">
                        <img src="<?= $admin['profile_image'] ?>" alt="Admin" class="adminprofile" />
                    </div>

                    <h3><?= $admin['fullname'] ?></h3>

                    <div class="info">
                        <p><i class="fa fa-envelope"></i> <?= $admin['email'] ?></p>
                        <p><i class="fa fa-phone"></i> <?= $admin['phone'] ?></p>
                    </div>
                </div>


                <div class="profile">
                    
                    <div class="profile-update">
                        <form method="POST" action="updateprofile.php" class="profile-form">
                            <h3>Account Setting</h3>

                            <label>Full Name</label>
                            <input type="text" name="fullname" value="<?= $admin['fullname'] ?>">

                            <label>Email</label>
                            <input type="email" name="email" value="<?= $admin['email'] ?>">

                            <label>Phone Number</label>
                            <input type="text" name="phone" value="<?= $admin['phone'] ?>">

                            <button type="submit" name="updateProfile">Update Profile</button>
                        </form>
                    </div>
                    

                    <div class="profile-update">
                        <form method="POST" action="" class="profile-form">
                            <h3>Securtiy</h3>
                            <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>
                            <?php if ($success) { echo "<p style='color:green;'>$success</p>"; } ?>

                            <label>Current Password</label>
                            <input type="password" name="currentpassword">

                            <label>New Password</label>
                            <input type="password" name="newpassword">

                            <label>Confirm Password</label>
                            <input type="password" name="confirmpassword">

                            <button type="submit" name="changePassword">Change Password</button>
                        </form>
                    </div>
                </div>

            </div>

            
        </main>

    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    

</body>
</html>