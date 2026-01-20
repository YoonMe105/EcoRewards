<?php
session_start();
include "dbcon.php";

$partnerId = $_SESSION['partner']['id'];

/* ---------------------------------------------------------
   STEP 1: FETCH CURRENT
    PROFILE DATA
--------------------------------------------------------- */
$query = "SELECT * FROM partners WHERE id = $partnerId";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

/* ---------------------------------------------------------
   STEP 2: UPDATE PROFILE LOGIC (If Edit form is submitted)
--------------------------------------------------------- */
if (isset($_POST['btnUpdateProfile'])) {
    $name    = $_POST['txtName'];
    $email   = $_POST['txtEmail'];
    $contact = $_POST['txtContact'];
    $phone   = $_POST['txtPhone'];
    $address = $_POST['txtAddress'];

    $updateQuery = "UPDATE partners 
                    SET name = '$name', email = '$email', contact_person = '$contact', 
                        phone = '$phone', address = '$address'
                    WHERE id = $partnerId";

    if(mysqli_query($conn, $updateQuery)){
        echo "<script>alert('UPDATE: Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "UPDATE Error: " . mysqli_error($conn) . "<br>";
    }
}

/* ---------------------------------------------------------
   STEP 3: CHANGE PASSWORD LOGIC (If Password form is submitted)
--------------------------------------------------------- */
if (isset($_POST['btnConfirmPassword'])) {
    $recentPass  = $_POST['txtRecentPass'];
    $newPass     = $_POST['txtNewPass'];
    $confirmPass = $_POST['txtConfirmPass'];

    // Basic verification logic
    if ($newPass !== $confirmPass) {
        echo "<script>alert('Passwords do not match!');</script>";
    } elseif ($recentPass !== $row['password']) {
        echo "<script>alert('Incorrect recent password!');</script>";
    } else {
        $updatePassQuery = "UPDATE partners SET password = '$newPass' WHERE id = $partnerId";
        
        if(mysqli_query($conn, $updatePassQuery)){
            echo "<script>alert('UPDATE: Password changed successfully'); window.location.href='profile.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - EcoRewards</title>
   
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/events.css">
    <style>
        body { font-family: sans-serif; background-color: #f0f0f0; display: flex; justify-content: center; padding: 20px; }
        .mobile-container { width: 375px; background: white; border: 8px solid #333; border-radius: 40px; padding: 20px; min-height: 600px; position: relative; }
        
        .header-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .profile-header { text-align: center; margin-bottom: 20px; }
        .avatar-circle { width: 80px; height: 80px; background: #ddd; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 40px; }
        
        .info-card { background: #e0e0e0; border-radius: 20px; padding: 20px; margin-bottom: 20px; position: relative; }
        .white-box { background: white; padding: 15px; border-radius: 10px; min-height: 150px; font-size: 14px; line-height: 2; }
        
        .edit-badge { position: absolute; right: 20px; top: 20px; background: #fff; border: 1px solid #ccc; padding: 5px 15px; border-radius: 5px; cursor: pointer; }
        
        .btn { width: 100%; padding: 12px; margin-bottom: 10px; border-radius: 10px; border: 1px solid #ccc; background: #fff; cursor: pointer; font-size: 14px; }
        .btn-primary { background: #eee; }
        
        .form-row { margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; }
        .form-row input { width: 60%; padding: 5px; border: 1px solid #999; }
        
        #passwordView { display: none; } /* Hidden by default */
    </style>
</head>
<body>
<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo">EcoRewards</div>
        </div>

        <nav>
            <a href="../partner/dashboard.php">Dashboard</a>
            <a href="../partner/marketing.php">Marketing Analysis</a>
            <a href="../partner/events/events.php" >Events</a>
            <a href="../partner/rewards/rewards.php">Rewards</a>
            <a href="../partner/profile.php" class="active">Profile</a>
        </nav>
    
    <div class="profile-header">
        <div class="avatar-circle">👤</div>
        <h2><?php echo $row['name']; ?></h2>
    </div>

    <div id="profileView">
        <div class="info-card">
            <button class="edit-badge" onclick="toggleEdit()">Edit</button>
            <div class="white-box">
                <b>ID:</b> <?php echo $row['id']; ?><br>
                <b>Email:</b> <?php echo $row['email']; ?><br>
                <b>Contact:</b> <?php echo $row['contact_person']; ?><br>
                <b>Phone:</b> <?php echo $row['phone']; ?><br>
                <b>Address:</b> <?php echo $row['address']; ?>
            </div>
        </div>
        <button class="btn" onclick="showPassword()">Change Password</button>
        <button class="btn" onclick="location.href='logout.php'">Log Out</button>
    </div>

    <div id="passwordView">
        <form method="post">
            <div class="info-card">
                <h3>Change Password</h3>
                <div class="white-box">
                    <div class="form-row">Recent Password: <input type="password" name="txtRecentPass" required></div>
                    <div class="form-row">New Password: <input type="password" name="txtNewPass" required></div>
                    <div class="form-row">Confirm New Password: <input type="password" name="txtConfirmPass" required></div>
                </div>
            </div>
            <div class="form-row">
                Dark mode: 
            <input type="checkbox" id="darkToggle" onclick="toggleTheme()" style="width:auto;">
            </div>
            <button type="submit" name="btnConfirmPassword" class="btn btn-primary">Confirm</button>
            <button type="button" class="btn" onclick="showProfile()">Cancel</button>
        </form>
    </div>
</div>

<script>
    function showPassword() {
        document.getElementById('profileView').style.display = 'none';
        document.getElementById('passwordView').style.display = 'block';
    }
    function showProfile() {
        document.getElementById('profileView').style.display = 'block';
        document.getElementById('passwordView').style.display = 'none';
    }
    function toggleTheme() {
    // Get the main phone container
    var element = document.querySelector(".mobile-container");
    
    // Toggle the 'dark-mode' class on or off
    element.classList.toggle("dark-mode");
}
    function toggleEdit() {
        alert("Redirecting to Edit Mode...");
        // You could swap the text into input fields here
    }
</script>

</body>
</html>