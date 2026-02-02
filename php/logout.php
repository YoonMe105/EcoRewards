<?php
session_start();

/* Clear all session data */
$_SESSION = [];

/* Destroy session */
session_destroy();

/* Optional: destroy session cookie */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

/* Redirect to guest page */
<<<<<<< HEAD:php/logout.php
header("Location: index.php"); // 🔁 CHANGE if needed
=======
header("Location: ../Guest/index.php"); // 🔁 CHANGE if needed
>>>>>>> a716b40cacc034e7302bb7d962f5903e8ed5d876:User/logout.php
exit;
?>