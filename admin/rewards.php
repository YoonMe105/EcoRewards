<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>

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
                    <h1>Rewards</h1>
                    <p>Manage available rewards for users.</p>
                </div>
                

                <button class="addrewards" id="addrewards">
                    <i class="fa-solid fa-plus"></i>
                     Add rewards
                </button>
            </div>

            <table class="rewardstable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Partner</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Points_required</th>
                        <th>Expired Date</th>
                        <th>status</th>
                        <th></th>
                    </tr>
                
                </thead>
                <?php
                include('conn.php');

                $sql = "Select * From rewards";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    die("<script>alert('No data from database!);</script>");
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$rows['id']."</td>";
                    echo "<td>".$rows['name']."</td>";
                    echo "<td>".$rows['partners_id']."</td>";
                    echo "<td>".$rows['description']."</td>";
                    echo "<td>".$rows['quantity']."</td>";
                    echo "<td>".$rows['points_required']."</td>";
                    echo "<td>".$rows['expired_at']."</td>";
                    echo "<td>".$rows['status']."</td>";

                    echo "<td class='action-buttons'>
                        <a href='editrewards.php?id=".$rows['id']."' class='btn-outline btnedit'>Edit</a>
                        <a href='deleterewards.php?id=".$rows['id']."' class='btn-outline btndelete'>Delete</a>
                    </td>";

                }

                mysqli_close($dbConn);

                ?>
                </table>
        </main>

        <!-- Start Add Reward Model -->
        <div id="myAddRewardModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Rewards</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Reward Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Reward Name" />
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-input" name="description" placeholder="Enter Description" />
                        </div>

                        <div class="form-group">
                            <label for="partner">Partner</label>
                            <input type="text" class="form-input" name="partner" placeholder="Enter Partner Organization" />
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="points">Points Required</label>
                                <input type="text" class="form-input" name="points" placeholder="Enter Points Required" />
                            </div>

                            <div class="form-group">
                                <label for="qty">Stock Quantity</label>
                                <input type="text" class="form-input" name="qty" placeholder="Enter Stock Quantity" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="exprieddate">Expired Date</label>
                                <input type="date" class="form-input" name="exprieddate" />
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="">
                                    <option value="available">Available</option>
                                    <option value="outofstock">Out of Stock</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="addbtn" name="addbtn">Add Reward</button>
                        </div>

                    </form>

                    
                </div>
                
            </div>
        </div>
        <!-- End Add Reward Model -->

        <?php

            include 'conn.php';

            if(isset($_POST['addbtn'])){
                $name        = $_POST['name'];
                $description = $_POST['description'];
                $partner     = $_POST['partner'];
                $points      = $_POST['points'];
                $qty         = $_POST['qty'];
                $expireddate = $_POST['exprieddate'];
                $status      = $_POST['status'];

                $sql = "INSERT INTO rewards
                ( `partners_id`, `name`, `description`, `quantity`, `points_required`, `expired_at`, `status`)
                        VALUES 
                        ('$partner','$name', '$description',   '$qty','$points', '$expireddate', '$status')";

                if (mysqli_query($dbConn, $sql)) {
                    echo "<script>alert('Reward added successfully!');</script>";
                    echo "<script>window.location.href='rewards.php';</script>";  
                } else {
                    echo "Error: " . mysqli_error($dbConn);
                }
            }

            mysqli_close($dbConn);

        ?>


    </div>
    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
        var addrewardbtn = document.getElementById('addrewards');
        var addmodal = document.getElementById('myAddRewardModal');
        var spanclose = document.getElementsByClassName('close')[0];
        var closebtn = document.getElementsByClassName('closebtn');

        addrewardbtn.onclick = function() {
            addmodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addmodal.style.display = "none";
        }

        function closeModal() {
            addmodal.style.display = "none";
        }
    </script>

</body>
</html>