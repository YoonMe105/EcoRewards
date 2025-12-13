<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 

    <!-- css -->
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include "navbar.php" ?>
    
    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <ul class="menulinks">
                <li>
                    <i class="fa-solid fa-house"></i>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <i class="fa-solid fa-gift"></i>
                    <a href="#">Rewards</a>
                </li>
                <li>
                    <i class="fa-solid fa-coins"></i>
                    <a href="#">Point Rules</a>
                </li>
                <li>
                    <i class="fa-solid fa-handshake"></i>
                    <a href="#">Partners</a>
                </li>
                <li class="has-submenu">
                    <div class="submenu-toggle">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Event</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </div>

                    <ul class="submenu">
                        <li><a href="#">Event Lists</a></li>
                        <li><a href="#">Event Approval</a></li>
                    </ul>
                </li>
    
                <li>
                    <i class="fa-solid fa-users"></i>
                    <a href="#">Users</a>
                </li>
                <li>
                    <i class="fa-solid fa-user-tie"></i>
                    <a href="#">Admins</a>
                </li>
                <li>
                    <i class="fa-regular fa-user"></i>
                    <a href="#">Profile</a>
                </li>
            </ul>
        </aside>

        <main class="content">
            <h1>Dashboard Content</h1>
            <p>Your page content goes here.</p>
        </main>
    </div>


    <script src="./assets/js/app.js" type="text/javascript"></script>

    
</body>
</html>