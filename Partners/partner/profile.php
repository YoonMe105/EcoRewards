<?php
session_start();

if (!isset($_SESSION['partner_id'])) {
    header("Location: ../login/login.php");
    exit();
}
include "db.php";

$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = $partnerId";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);
$row = $partner;

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
    <title> Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo">EcoRewards</div>
        </div>

        <div class="profile" style="padding: 20px; text-align: center; border-bottom: 1px solid #f3f4f6;">
            <div class="avatar-circle" style="width: 80px; height: 80px; margin: 0 auto 10px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <?php 
                $imagePath = "../image/" . $partner['name'] . ".png";
                if (file_exists($imagePath)) {
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
                } else {
                    echo '<span style="font-size: 30px;">👤</span>';
                }
                ?>
            </div>
            <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partner['name']) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="partner_homepage.php" class="nav-item">Dashboard</a>
            <a href="marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events/events.php" class="nav-item">Events</a>
            <a href="rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="profile.php" class="nav-item active">Profile</a>
        </nav>
    </aside>
    
    <main class="main">
        <div class="mobile-container">
            
            

            <h2 style="text-align:center; margin-bottom:20px;"><?= htmlspecialchars($row['name']) ?></h2>

            <div id="profileView">
                <div class="card" style="text-align: left; margin-bottom: 20px; padding: 20px;">
                    <p><b>ID:</b> <?php echo $row['id']; ?></p>
                    <p><b>Email:</b> <?php echo $row['email']; ?></p>
                    <p><b>Contact:</b> <?php echo $row['contact_person']; ?></p>
                    <p><b>Phone:</b> <?php echo $row['phone']; ?></p>
                    <p><b>Address:</b> <?php echo $row['address']; ?></p>
                </div>
                <button class="btn btn-block" onclick="showPassword()">Change Password</button>
            </div>

            <div id="passwordView" style="display:none;">
                <form method="post">
                    <div class="card" style="text-align: left; margin-bottom: 20px; padding: 20px;">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label>Recent Password:</label>
                            <input type="password" name="txtRecentPass" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>New Password:</label>
                            <input type="password" name="txtNewPass" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password:</label>
                            <input type="password" name="txtConfirmPass" class="form-input" required>
                        </div>
                    </div>
                    
                    
                    
                    <button type="submit" name="btnConfirmPassword" class="btn btn-primary btn-block" style="margin-bottom: 10px;">Confirm</button>
                    <button type="button" class="btn btn-block" style="background: #999;" onclick="showProfile()">Cancel</button>
                </form>
            </div>
        </div>
    </main>
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
    
</script>
</body>

</html>


