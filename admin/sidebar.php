<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Bar</title>

    <!-- css -->
    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>
    

    <aside class="sidebar" id="sidebar">
        <ul class="menulinks">
            <li class="link">
                <i class="fa-solid fa-house"></i>
                <a href="index.php">Dashboard</a>
            </li>

            <li class="link">
                <i class="fa-solid fa-gift"></i>
                <a href="rewards.php">Rewards</a>
            </li>

            <li class="link">
                <i class="fa-solid fa-coins"></i>
                <a href="pointsrule.php">Point Rules</a>
            </li>

            <li class="link">
                <i class="fa-solid fa-handshake"></i>
                <a href="partners.php">Partners</a>
            </li>

            <li class="has-submenu">
                <a href="#" class="submenubtn">
                    <i class="fa-solid fa-calendar events"></i>
                    <span>Events</span>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </a>

                <ul class="submenu">
                    <li><a href="eventlists.php">Event Lists</a></li>
                    <li><a href="eventapproval.php">Event Approval</a></li>
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
    
</body>
</html>