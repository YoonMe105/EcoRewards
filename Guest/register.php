<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ecorewards");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only process if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data safely
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Check required fields
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Check password match
    if ($password !== $confirm) {
        echo "Passwords do not match";
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload safely
    $uploadPath = ''; // default empty
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $imageName = $_FILES['profile_image']['name'];
        $tmpName = $_FILES['profile_image']['tmp_name'];
        $uploadPath = "uploads/" . time() . "_" . basename($imageName);
        move_uploaded_file($tmpName, $uploadPath);
    }

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, role, password, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $email, $phone, $role, $hashedPassword, $uploadPath);

    if ($stmt->execute()) {
        // AUTO LOGIN (SESSION)
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['role'] = $role;

        // Redirect to user main page
        header("Location: homepage.php");
        exit();
    } else {
        echo "Registration failed: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
