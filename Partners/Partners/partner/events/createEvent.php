<?php
session_start();
if (!isset($_SESSION['partner_id'])) {
    header("Location: ../php/login.php");
    exit;
}
include "../../php/db.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

if (isset($_POST['btnCreate'])) {

    $event_id      = $_POST['txtEventid'];
    $event_name    = $_POST['txtEventname'];
    $description   = $_POST['txtaDescription'];
    $start_date    = $_POST['start_date'];
    $end_date      = $_POST['end_date'];
    $points_reward = $_POST['points_reward'];
    $created_at    = $_POST['created_at'];

    /* Image upload */
    $image_name = $_FILES['image']['name'];
    $tmp_name   = $_FILES['image']['tmp_name'];

    $upload_folder = "image/" . $image_name; 
    
    $db_image_path = "image/" . $image_name;
    move_uploaded_file($tmp_name, $upload_folder);

    $sql = "INSERT INTO events 
            (id, name, description, start_date, end_date, points_reward, created_at, image, partners_id, status, admins_id, approved_by)
            VALUES 
            ('$event_id', '$event_name', '$description', '$start_date', '$end_date', '$points_reward', '$created_at', '$db_image_path', '$partnerId', 'upcoming', 1, 1)";

    // Execute and Check
    if(mysqli_query($conn, $sql)){
        echo "<script>
                alert('INSERT: New event added successfully');
                window.location.href='events.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
   <link rel="stylesheet" href="../../assets/style.css">

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
                $imagePath = "../../image/" . $partner['name'] . ".png";
                if (file_exists($imagePath)) {
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
                } else {
                    echo '<span style="font-size: 30px;">👤</span>';
                }
                ?>

        ?>
        </div>
        <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partner['name']) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="../dashboard.php" class="nav-item">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events.php" class="nav-item active">Events</a>
            <a href="../rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <div><h1>Create Events</h1></div>
        
        <a href="events.php" class="btn" style="background: #999;">Back</a>
        </header>

        <div class="card" style="max-width: 800px;">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">

                <div class="form-group">
                    Event ID:
                    <input type="number" name="txtEventid" class="form-input" required placeholder="e.g. 101">
                </div>

                <div class="form-group">
                    Event Name:
                    <input type="text" name="txtEventname" class="form-input" required placeholder="e.g. Beach Cleanup">
                </div>

                <div class="form-group">
                    Description:
                    <textarea name="txtaDescription" class="form-input" required placeholder="Event details..."></textarea>
                </div>

                <div class="form-group">
                    Start Date & Time:
                    <input type="datetime-local" name="start_date" class="form-input" required>
                </div>

                <div class="form-group">
                    End Date & Time:
                    <input type="datetime-local" name="end_date" class="form-input" required>
                </div>

                <div class="form-group">
                    Points Reward:
                    <input type="number" name="points_reward" class="form-input" required placeholder="e.g. 50">
                </div>

                <div class="form-group">
                    Created At:
                    <input type="datetime-local" name="created_at" class="form-input" required>
                </div>

                <div class="form-group">
                    Event Image:
                    <input type="file" name="image" accept="image/*" class="form-input" required>
                </div>
                
                <button type="submit" name="btnCreate" class="btnSubmit">Create Event</button>
            </form>
        </div>
    </main>
</div>

</body>
</html>