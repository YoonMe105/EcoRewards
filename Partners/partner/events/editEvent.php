<?php
session_start();
if (!isset($_SESSION['partner_id'])) {    header("Location: ../login/login.php");
    exit();
}

include "db.php";
$partnerId = $_SESSION['partner_id'];
$query = "SELECT * FROM partners WHERE id = '$partnerId'";
$result = mysqli_query($conn, $query);
$partner = mysqli_fetch_assoc($result);

// 1. Check if ID is set
if (!isset($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$eventId = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Fetch existing event data
$query = "SELECT * FROM events WHERE id = '$eventId' AND partners_id = '$partnerId'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Event not found or you don't have permission to edit it.";
    exit();
}

$row = mysqli_fetch_assoc($result);

// 3. Handle Update Logic
if (isset($_POST['btnUpdate'])) {
    $name          = mysqli_real_escape_string($conn, $_POST['name']);
    $description   = mysqli_real_escape_string($conn, $_POST['description']);
    $start_date    = $_POST['start_date'];
    $end_date      = $_POST['end_date'];
    $points_reward = $_POST['points_reward'];
    $status        = $_POST['status'];

    // Image Upload Logic (Optional Update)
    $imageUpdateSQL = "";
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $target = "image/" . basename($imageName);
        move_uploaded_file($_FILES['image']['tmp_name'], "../../" . $target);
        $imageUpdateSQL = ", image = '$target'";
    }

    $updateQuery = "UPDATE events SET 
                    name = '$name', 
                    description = '$description', 
                    start_date = '$start_date', 
                    end_date = '$end_date', 
                    points_reward = '$points_reward',
                    status = '$status'
                    $imageUpdateSQL
                    WHERE id = '$eventId' AND partners_id = '$partnerId'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Event updated successfully!'); window.location.href='events.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-top"><div class="logo">EcoRewards</div></div>
        
        <div class="profile" style="padding: 20px; text-align: center; border-bottom: 1px solid #f3f4f6;">
            <div class="avatar-circle" style="width: 80px; height: 80px; margin: 0 auto 10px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <?php 
                $partnerName = $_SESSION['partners']['name'];
                $imagePath = "../../image/" . $partnerName . ".png";
                if (file_exists($imagePath)) {
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Profile" style="width:100%; height:100%; object-fit:cover;">';
                } else {
                    echo '<span style="font-size: 30px;">👤</span>';
                }
                ?>
            </div>
            <div class="profile-info">
                <div class="name" style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($partnerName) ?></div>
                <div class="role" style="color: #6b7280; font-size: 14px;">Partner</div>
            </div>
        </div>

        <nav class="nav">
            <a href="../partner_homepage.php" class="nav-item">Dashboard</a>
            <a href="../marketing.php" class="nav-item">Marketing Analysis</a>
            <a href="events.php" class="nav-item active">Events</a>
            <a href="../rewards/rewards.php" class="nav-item">Rewards</a>
            <a href="../profile.php" class="nav-item">Profile</a>
        </nav>
    </aside>

    <main class="main">
        <header class="main-header">
            <div>
                <h1>Edit Event</h1>
                <p>Update details for: <b><?= htmlspecialchars($row['name']) ?></b></p>
            </div><br>
            <a href="events.php" class="btn" style="background: #9ca3af;">Cancel</a>
        </header>

        <div class="card" style="max-width: 800px;">
            <form method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($row['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-input" rows="4" required><?= htmlspecialchars($row['description']) ?></textarea>
                </div>

                <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <div>
                        <label>Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-input" value="<?= date('Y-m-d\TH:i', strtotime($row['start_date'])) ?>" required>
                    </div>
                    <div>
                        <label>End Date</label>
                        <input type="datetime-local" name="end_date" class="form-input" value="<?= date('Y-m-d\TH:i', strtotime($row['end_date'])) ?>" required>
                    </div>
                </div>

                <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <div>
                        <label>Points Reward</label>
                        <input type="number" name="points_reward" class="form-input" value="<?= $row['points_reward'] ?>" required>
                    </div>
                    <div>
                        <label>Status</label>
                        <select name="status" class="form-input">
                            <option value="upcoming" <?= $row['status'] == 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                            <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="ended" <?= $row['status'] == 'ended' ? 'selected' : '' ?>>Ended</option>
                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Current Image</label><br>
                    <?php if(!empty($row['image'])): ?>
                        <img src="../../<?= $row['image'] ?>" style="width: 150px; border-radius: 8px; margin-bottom: 10px;">
                    <?php else: ?>
                        <p style="color:#999;">No image set.</p>
                    <?php endif; ?>
                    <br>
                    <label>Change Image (Optional)</label>
                    <input type="file" name="image" class="form-input" accept="image/*">
                </div>

                <button type="submit" name="btnUpdate" class="btn btn-block">Save Changes</button>

            </form>
        </div>
    </main>
</div>

</body>
</html>


