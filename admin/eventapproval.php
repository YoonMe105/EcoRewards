<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Approval</title>

    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Event Approval</h1>
                </div>
                
            </div>



            <?php
                include "conn.php";

                $sql = "Select events.*,partners.name As pname From events Left Join partners On events.partners_id = partners.id where status ='pending'";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    echo "<h3>No Events to approve</h3>";
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<div class='approval-card'>";
                    echo "<div class='event-top'>";
                    echo "<h3>".$rows['name']."</h3>";
                    echo "<p>".$rows['description']."</p>";
                    echo "</div>";

                    echo "<div class='event-info'>";
                    echo "<span>📅". $rows['start_date'] ." to ". $rows['end_date']."</span>";
                    echo "<span>🤝". $rows['pname'] ."</span>";
                    echo "</div>";

                    echo "<div class='event-bottom'>";
                    echo "<span class='points'> Reward - ". $rows['points_reward'] ."</span>";
                    echo "<div class='actions'>";
                    echo "<a href='?action=approve&id=".$rows['id']."' class='btn approve'>Approve</a>";
                    echo "<a href='?action=reject&id=".$rows['id']."' class='btn reject'>Reject</a>";
                    echo "</div>";
                    echo "</div>";

                    echo "</div>";
                }
            
                
            ?>

            <?php

                if (isset($_GET['action']) && isset($_GET['id'])) {

                    $id = $_GET['id'];
                    $action = $_GET['action'];

                    if ($action === 'approve') {
                        $sql = "UPDATE events SET status = 'active' WHERE id = '$id'";
                        $result = mysqli_query($dbConn,$sql);
                        

                        echo "<script>
                                alert('Status updated!');
                                window.location='eventapproval.php';
                            </script>";
                    } elseif ($action === 'reject') {
                       $sql = "UPDATE events SET status = 'rejected' WHERE id = '$id'";
                        $result = mysqli_query($dbConn,$sql);


                        echo "<script>
                                alert('Status updated!');
                                window.location='eventapproval.php';
                            </script>";
                    }

        
                }

                mysqli_close($dbConn);
            ?>



            
                
                
            </div>

            
        </main>

        

        

    </div>
    
    

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>