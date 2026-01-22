<?php
require "db.php";

$user_id = $_SESSION["user_id"] ?? 1;
$event_id = $_POST["event_id"];

$questions = $conn->query("SELECT * FROM event_questions WHERE events_id=$event_id");

$score = 0;
while($q=$questions->fetch_assoc()){
  if(isset($_POST["q".$q['id']]) && $_POST["q".$q['id']] == $q['correct']){
    $score += 5;
  }
}

/* Update user points */
$conn->query("UPDATE users SET total_points = total_points + $score WHERE id=$user_id");

/* Log event */
$conn->query("INSERT INTO event_logs (events_id, users_id, status)
              VALUES ($event_id, $user_id, 'completed')");

header("Location: homepage.php");
?>