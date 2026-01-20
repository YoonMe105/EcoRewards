<?php
session_start();
include '../config/dbcon.php';

if (isset($_POST['btnLogin'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM partners WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        $_SESSION['partner'] = $row; 
    

        // Redirect to dashboard
        header("Location: ../dashboard.php");
        exit();

    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EcoRewards | Login</title>

    <!-- Still needed for mobile simulation -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <style>
        /* CONTENT */
        .content {
            padding: 20px;
            margin-top: 40px;
            font-size: 23px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        /* FORM */
        label {
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }    

         /* BUTTON */
        button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background: #54a582;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        /* FORGOT */
        .forgot {
            text-align: right;
            margin-top: 0px;
        }

        .forgot a {
            color: #a2cbb9;
            text-decoration: none;
            font-size: 14px;
        }

        /* ERROR */
        #error-msg {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <span class="logo">EcoRewards</span>
    </header>

    <!-- CONTENT -->
    <div class="content">

        <h2>LOGIN</h2>

        <form method="POST" action="">

    <label>Email</label>
    <input type="email" name="email" placeholder="Email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password" required>

    <p class="forgot">
        <a href="forgot_password.html">Forgot password?</a>
    </p>
    
    <button type="submit" name="btnLogin">LOGIN</button>

    <p id="error-msg"><?php echo isset($error) ? $error : ''; ?></p>

</form>

    </div>

</body>
</html>
