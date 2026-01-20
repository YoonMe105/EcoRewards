<?php
require "db.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['reward_id'])) {
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$reward_redemption_id = (int)$_POST['reward_id'];

// Mark voucher as used
$conn->query("
    UPDATE reward_redemption
    SET status = 'used'
    WHERE id = $reward_redemption_id
      AND users_id = $user_id
");

// IMPORTANT: output ONLY this
echo "success";
exit;
?>