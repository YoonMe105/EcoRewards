<?php
    session_start();

    include 'conn.php';

    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../User/login.php");
        exit;
    }
?>

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

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        
        <?php include('sidebar.php') ?>

        <main class="main">
            <h1>Dashboard</h1>
            <p>Welcome back! Here's what's happening with EcoRewards today.</p>

            <div class="cards">
                <div class="card">
                    <div class="name">
                        <h3>User</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM users";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                    <i class="fa-solid fa-users fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Partners</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM partners";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                    <i class="fa-solid fa-handshake fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Rewards</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM rewards";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                    <i class="fa-solid fa-gift fa-3x icons"></i>
                </div>

                <div class="card">
                    <div class="name">
                        <h3>Events</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM events";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                    <i class="fa-solid fa-calendar fa-3x icons"></i>
                </div>
            </div>

            <h1 class="items">Recycle Items</h1>
            <div class="cards">
                <div class="card">
                     <img src="./assets/img/metal.png" width="100px" height="80px" />
                    <div class="name">
                        <h3>Metal</h3>

                        <?php

                            $sql = "SELECT COUNT(*) FROM eco_actions Where material_type='metal'";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>

                    </div>
                </div>

                <div class="card">
                     <img src="./assets/img/glass.png" width="100px" height="80px" />

                    <div class="name">
                        <h3>Glass</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM eco_actions Where material_type='glass'";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                </div>

                <div class="card">
                     <img src="./assets/img/plastic.png" width="100px" height="80px" />

                    <div class="name">
                        <h3>Plastic</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM eco_actions Where material_type='plastic'";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                        ?>
                    </div>
                </div>

                <div class="card">                     
                    <img src="./assets/img/paper.png" width="100px" height="80px" />
                    <div class="name">
                        <h3>Paper</h3>
                        <?php

                            $sql = "SELECT COUNT(*) FROM eco_actions Where material_type='paper'";
                            $result = mysqli_query($dbConn, $sql);
                            $row = mysqli_fetch_row($result);

                            echo "<strong>{$row[0]}</strong>";
                          
                            mysqli_close($dbConn);
                        ?>
                    </div>
                </div>
            </div>

        </main>
    </div>
    
    
    <script src="./assets/js/app.js" type="text/javascript"></script>

    
</body>
</html>