<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page for Admin</title> 

    <!-- css -->
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('navbar.php') ?>

    <div class="wrapper">
        
        <aside class="sidebar" id="sidebar">
            <ul class="menulinks">
                <li class="link">
                    <i class="fa-solid fa-house"></i>
                    <a href="#">Dashboard</a>
                </li>

                <li class="link">
                    <i class="fa-solid fa-gift"></i>
                    <a href="#">Rewards</a>
                </li>

                <li class="link">
                    <i class="fa-solid fa-coins"></i>
                    <a href="#">Point Rules</a>
                </li>

                <li class="link">
                    <i class="fa-solid fa-handshake"></i>
                    <a href="#">Partners</a>
                </li>

                <li class="has-submenu">
                    <a href="#" class="submenubtn">
                        <i class="fa-solid fa-calendar events"></i>
                        <span>Events</span>
                        <i class="fa-solid fa-chevron-down arrow"></i>
                    </a>

                    <ul class="submenu">
                        <li><a href="#">Event Lists</a></li>
                        <li><a href="#">Event Approval</a></li>
                    </ul>
                </li>

                <li class="link">
                    <i class="fa-solid fa-users"></i>
                    <a href="#">Users</a>
                </li>

                <li class="link">
                    <i class="fa-solid fa-user-tie"></i>
                    <a href="#">Admins</a>
                </li>

                <li class="link">
                    <i class="fa-regular fa-user"></i>
                    <a href="#">Profile</a>
                </li>
            </ul>
        </aside>

        <main class="main">
            <h1>Dashboard</h1>
            <p>Welcome back! Here's what's happening with EcoRewards today.</p>

            <div class="cards">
                <div class="card">
                    <div class="name">
                        <h3>User</h3>
                        <strong>10</strong>
                    </div>
                    <i class="fa-solid fa-users fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Partners</h3>
                        <strong>10</strong>
                    </div>
                    <i class="fa-solid fa-handshake fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Rewards</h3>
                        <strong>10</strong>
                    </div>
                    <i class="fa-solid fa-gift fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Events</h3>
                        <strong>10</strong>
                    </div>
                    <i class="fa-solid fa-calendar fa-3x icons"></i>
                </div>
            </div>

            <h1 class="items">Recycle Items</h1>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-users fa-3x icons"></i>
                    <div class="name">
                        <h3>User</h3>
                        <strong>10</strong>
                    </div>
                </div>

                <div class="card">
                    <i class="fa-solid fa-users fa-3x icons"></i>
                    <div class="name">
                        <h3>Partners</h3>
                        <strong>10</strong>
                    </div>
                </div>

                <div class="card">
                    <i class="fa-solid fa-users fa-3x icons"></i>
                    <div class="name">
                        <h3>Rewards</h3>
                        <strong>10</strong>
                    </div>
                </div>

                <div class="card">
                    <i class="fa-solid fa-users fa-3x icons"></i>
                    <div class="name">
                        <h3>Events</h3>
                        <strong>10</strong>
                    </div>
                </div>
            </div>

        </main>
    </div>
    
    
    <script src="./assets/js/app.js" type="text/javascript"></script>

    
</body>
</html>