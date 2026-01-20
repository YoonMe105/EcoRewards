<?php
include 'conn.php';


$view_id = null;
$event = null;
$showModal = false;

if (isset($_GET['action']) && $_GET['action'] === 'view' && isset($_GET['id'])) {
    $view_id = intval($_GET['id']);

    $sql = "SELECT events.*, partners.name AS pname
            FROM events
            LEFT JOIN partners ON events.partners_id = partners.id
            WHERE events.id = $view_id
            LIMIT 1";

    $result = mysqli_query($dbConn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        $showModal = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Lists</title>

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
                    <h1>Event Lists</h1>
                    <p>Organize and manage recycling event lists.</p>
                </div>
                

                <button class="adduser" id="addevents">
                    <i class="fa-solid fa-plus"></i>
                     Create Event
                </button>
            </div>

            <?php 

                include "conn.php";

                $sql = "Select events.*,partners.name As pname From events Left Join partners On events.partners_id = partners.id where status ='active'";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    echo "<h3>There is no events in these days.</h3>";
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<div class='event-card'>";
                    echo "<div class='event-top'>";
                    echo "<h3>".$rows['name']."</h3>";
                    echo "<span class='status ".$rows['status']."'>".$rows['status']."</p>";
                    echo "</div>";

                    echo "<div class='event-info'>";
                    echo "<span>📅". $rows['start_date'] ." to ". $rows['end_date']."</span>";
                    echo "<span>🤝". $rows['pname'] ."</span>";
                    echo "</div>";

                    echo "<div class='event-bottom'>";
                    echo "<span class='points'> Points - ". $rows['points_reward'] ."</span>";
                    echo "<div class='actions'>";
                    echo "<a href='?action=view&id=".$rows['id']."' class='btn view'>View Details</a>";
                    
                    echo "<a href='editevent.php?id=".$rows['id']."' class='btn edit'>Edit</a>";
                    echo "<a href='deleteevent.php?id=".$rows['id']."' class='btn delete'>Delete</a>";
                    echo "</div>";
                    echo "</div>";

                    echo "</div>";
                }
            
                
            ?>
            
        </main>

        <!-- Start Add event Model haven't done -->
        <div id="myAddEventModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Event</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Event Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Event Name" />
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-input" name="description" placeholder="Enter Description" />
                        </div>

                        <div class="form-group">
                            <label for="partner">Partner</label>
                            <input type="text" class="form-input" name="partner" placeholder="Enter Partner" />
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="startdate">Start Date</label>
                                <input type="date" class="form-input" name="startdate" placeholder="Enter Start Date" />
                            </div>

                            <div class="form-group">
                                <label for="enddate">End Date</label>
                                <input type="date" class="form-input" name="enddate" placeholder="Enter End Date" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="point">Point Reward</label>
                                <input type="text" class="form-input" name="point" placeholder="Enter Point Reward" />
                            </div>

                            <div class="form-group">
                                <label for="event">Event Image</label>
                                <input type="file" class="form-input" name="event" placeholder="Browse..." />
                            </div>
                        </div>

                        

                        <div class="modal-footer">
                            <button type="button" name="cancelbtn" class="cancelbtn">Cancel</button>
                            <button type="submit" name="addbtn" class="addbtn">Add Event</button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
        <!-- End Add event Model -->

        <?php

            include 'conn.php';

            if(isset($_POST['addbtn'])){
                $name        = $_POST['name'];
                $description = $_POST['description'];
                $partner     = $_POST['partner'];
                $point      = $_POST['point'];
                $startdate         = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $status = "active";

                $profileName = $_FILES['event']['name'];
                $tmpName     = $_FILES['event']['tmp_name'];

                if (!empty($profileName)) {
                    $folder = "assets/img/";
                    $newName = basename($profileName);
                    move_uploaded_file($tmpName, $folder . $newName);
                    $profilePath = $folder . $newName;
                } else {
                    $profilePath = "assets/img/default-profile.png";
                }

                $partner_sql = "SELECT id FROM partners WHERE name = '$partner'";
                $partner_res = mysqli_query($dbConn, $partner_sql);

                if (!$partner_res || mysqli_num_rows($partner_res) == 0) {
                    die("Partner not found");
                }

                $partner_row = mysqli_fetch_assoc($partner_res);
                $partner_id  = $partner_row['id'];


                $sql = "INSERT INTO events
                ( `name`, `description`, `image`, `start_date`, `end_date`,`points_reward`,`partners_id`, `status`)
                        VALUES 
                        ('$name', '$description',   '$profilePath', '$startdate', '$enddate' ,'$point', '$partner_id', '$status')";

                if (mysqli_query($dbConn, $sql)) {
                    echo "<script>alert('Event added successfully!');</script>";
                    echo "<script>window.location.href='eventlists.php';</script>";  
                } else {
                    echo "Error: " . mysqli_error($dbConn);
                }
            }

            mysqli_close($dbConn);

        ?>



        <?php if ($event) { ?>
        <!-- start view details -->
        <div class="modal viewModal" id="viewModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Event Details</h3>
                    <button class="close-btn" onclick="closeModal()">✕</button>
                </div>

                <div class="modal-body">
                    <h4><?= $event['name']; ?></h4>

                    <div class="modal-section">
                        <strong>Description</strong>
                        <p><?= $event['description']; ?></p>
                    </div>

                    <div class="modal-section">
                        <strong>Date</strong>
                        <p>
                            <?= date('d M Y', strtotime($event['start_date'])); ?>
                            -
                            <?= date('d M Y', strtotime($event['end_date'])); ?>
                        </p>
                    </div>

                    <div class="modal-section">
                        <strong>Partner</strong>
                        <p><?= $event['pname']; ?></p>
                    </div>

                    <div class="modal-section">
                        <strong>Points Reward</strong>
                        <p><?= $event['points_reward']; ?></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn cancel" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- end view details -->

    </div>
    
    <script type="text/javascript">
        var addeventbtn = document.getElementById('addevents');
        var addeventmodal = document.getElementById('myAddEventModal');
        var spanclose = document.getElementsByClassName('close')[0];


        addeventbtn.onclick = function() {
            addeventmodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addeventmodal.style.display = "none";
        }

        <?php if ($showModal) { ?>
            document.getElementById('viewModal').style.display = 'block';
        <?php } ?>


        function closeModal() {
            window.location.href = 'eventlists.php';
        }
    </script>

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>