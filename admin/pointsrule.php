<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Points Rule</title>

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
                    <h1>Point Rules</h1>
                    <p>Manage user point rules across the platform.</p>
                </div>
                

                <button class="adduser" id="addrules">
                    <i class="fa-solid fa-plus"></i>
                     Add Point Rule
                </button>
            </div>

            <table class="rewardstable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Material Type</th>
                        <th>Unit</th>
                        <th>Points</th>
                        <th>status</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                
                </thead>
                <?php
                include('conn.php');
                $sql = "Select * From point_rules";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    die("<script>alert('No data from database!);</script>");
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$rows['id']."</td>";
                    echo "<td>".$rows['material_type']."</td>";
                    echo "<td>".$rows['unit']."</td>";
                    echo "<td>".$rows['points']."</td>";
                    echo "<td>".$rows['status']."</td>";
                    echo "<td>".$rows['created_at']."</td>";

                    echo "<td class='action-buttons'>
                        <a href='editrule.php?id=".$rows['id']."' class='btn-outline btnedit'>Edit</a>
                        <a href='deleterule.php?id=".$rows['id']."' class='btn-outline btndelete'>Delete</a>
                    </td>";


                }

                ?>
                </table>
        </main>

        <!-- Start Add Rule Model -->
        <div id="myAddRuleModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Point Rules</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="type">Material Type</label>
                            <input type="text" class="form-input" name="type" placeholder="Enter Material Type" />
                        </div>

                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" class="form-input" name="unit" placeholder="Enter Unit" />
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="points">Points</label>
                                <input type="text" class="form-input" name="points" placeholder="Enter Points Required" />
                            </div>


                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="cancelbtn btn" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="addbtn btn" name="addbtn">Add Rule</button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
        <!-- End Add Rule Model -->

        <?php

            include 'conn.php';

            if(isset($_POST['addbtn'])){
                $type        = $_POST['type'];
                $unit = $_POST['unit'];
                $points     = $_POST['points'];
                $status      = $_POST['status'];

                $sql = "INSERT INTO point_rules
                ( `material_type`, `unit`, `points`, `status`)
                        VALUES 
                        ('$type','$unit', '$points', '$status')";

                if (mysqli_query($dbConn, $sql)) {
                    echo "<script>alert('Points added successfully!');</script>";
                    echo "<script>window.location.href='pointsrule.php';</script>";  
                } else {
                    echo "Error: " . mysqli_error($dbConn);
                }
            }

        ?>

    </div>
    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
        var addrulebtn = document.getElementById('addrules');
        var addrulemodal = document.getElementById('myAddRuleModal');
        var spanclose = document.getElementsByClassName('close')[0];


        addrulebtn.onclick = function() {
            addrulemodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addrulemodal.style.display = "none";
        }

        function closeModal() {
            addrulemodal.style.display = "none";
        }

    </script>
</body>
</html>