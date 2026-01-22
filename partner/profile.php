<?php
session_start();

if (!isset($_SESSION['partners'])) {
    header("Location: ../login/login.php");
    exit();
}
include "../config/dbcon.php";
$partner = $_SESSION['partners'];
$partnerId = $partner['id'];

$query = "SELECT * FROM partners WHERE id = $partnerId";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

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
<html>
<head>
    <title> Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo">EcoRewards</div>
        </div>

        <nav class="nav">
            <a href="../partner/dashboard.php" class="nav-item">Dashboard</a>
            <a href="../partner/marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="../partner/events/events.php" class="nav-item">Events</a>
            <a href="../partner/rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../partner/profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>
    
    <main class="main">
        <div class="mobile-container">
            
            <div class="avatar-circle" style="padding: 20px; text-align: center; border-bottom: 1px solid #f3f4f6;">
                <?php 
                // Check if the database has an image string
                if (!empty($row['company_image'])) {
                    // We add '../' because the image is likely in the root img/ folder
                    // and this file is inside the partner/ folder.
                    echo '<img src="../' . htmlspecialchars($row['company_image']) . '" alt="Profile" class="avatar-img">';
                } else {
                    // Fallback to icon if no image is found
                    echo '👤'; 
                }
                ?>
            </div>

            <h2 style="text-align:center; margin-bottom:20px;"><?= htmlspecialchars($row['name']) ?></h2>

            <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partner['name']) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="dashboard.php" class="nav-item active">Dashboard</a>
            <a href="marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events/events.php" class="nav-item">Events</a>
            <a href="rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <div>
                <h1>Dashboard</h1>
            </div>
            <a href="../auth/logout.php" class="btn" style="background-color: #ef4444; text-decoration: none; color: white;">Logout</a>
        </header>
        <div class="mobile-container" style="padding: 20px; max-width: 600px; margin: auto;">
    <div id="profileView">
        <div class="info-card">
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
                    <div class="form-row">Recent Password: <input type="password" name="txtRecentPass" required></div>
                    <div class="form-row">New Password: <input type="password" name="txtNewPass" required></div>
                    <div class="form-row">Confirm New Password: <input type="password" name="txtConfirmPass" required></div>
                </div>
            </div>
            <div class="form-row">
            <span>Dark mode: </ span>
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
    document.querySelector(".mobile-container");
    
//     // Toggle the 'dark-mode' class on or off
//     element.classList.toggle("dark-mode");
// }
//     function toggleEdit() {
//         alert("Redirecting to Edit Mode...");
//         // You could swap the text into input fields here
//     }
</script>

</body>
</html>