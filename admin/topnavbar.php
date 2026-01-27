<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOP Navbar</title>

    <!-- css -->
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />

    <style>

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>
    
    <div class="top-navbar">
        <button class="navbutton" id="toggleSidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
        <img src="./assets/img/logo.png" alt="logo" class="logoimg" />
        <div class="logo">EcoRewards</div>

        <div class="nav-right">
            <!-- <button class="darkmode" id="darkmode">
                <i class="fa-regular fa-moon" id="icon"></i>
            </button> -->
            <a href="../User/logout.php" class="logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </div>

    <script>
        var bgbtn = document.getElementById('darkmode');

        bgbtn.onclick = function () {
            document.body.style.backgroundColor = "#000";
            document.body.style.color = "#fff";
        };
    </script>

</body>
</html>




