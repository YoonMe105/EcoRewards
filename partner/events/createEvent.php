<?php
session_start();
if (!isset($_SESSION["partners"])) {
    header("Location: ../login/login.php");
    exit;
}
include "../config/db.php";

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
    $folder     = "img/" . $image_name;

    move_uploaded_file($tmp_name, $folder);

    $sql = "INSERT INTO events 
                    (id, event_name, description, start_date, end_date, points_reward, created_at, image)
                    VALUES 
                    ('$event_id', '$event_name', '$description', '$start_date', '$end_date', '$points_reward', '$created_at', '$image_name')";

    // Execute and Check (Imitating the if/else logic)
    if(mysqli_query($conn, $sql)){
        // Success
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
    <title>Create Event</title>
</head>
<body>

<header class="top-bar">
    <h1>🌱 EcoRewards</h1>
    <a href="logout.php" class="logout">Log out</a>
</header>

<div class="container">
    <aside class="sidebar">
        <nav>
            <a href="../partner/dashboard.php">Dashboard</a>
            <a href="../partner/marketing.php">Marketing Analysis</a>
            <a href="../partner/events/events.php" class="active">Events</a>
            <a href="../partner/rewards/rewards.php">Rewards</a>
            <a href="../partner/profile.php">Profile</a>
        </nav>
    </aside>

    <main class="content">
        <a href="events.php" class="btn-back">← Back to Events List</a>

        <div class="form-container">
            <div class="form-header">
                <h2>Create New Event</h2>
                <p>Fill in the details to publish a new event.</p>
            </div>
            
            <form action="createEvent.php" method="post" enctype="multipart/form-data">

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
                <button type="submit" name="btnCreate" class="btn-submit">Publish Event</button>
            </form>
        </div>
    </main>
</div>

</body>
</html>