<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

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
                    <h1>Users</h1>
                    <p>Manage your EcoRewards community.</p>
                </div>
                

                <button class="addusers" id="addusers">
                    <i class="fa-solid fa-plus"></i>
                     Add users
                </button>
            </div>

            <table class="rewardstable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Points</th>
                        <th></th>
                    </tr>
                
                </thead>
                <?php
                include('conn.php');

                $sql = "Select * From users";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    die("<script>alert('No data from database!);</script>");
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$rows['id']."</td>";
                    echo "<td>".$rows['fullname']."</td>";
                    echo "<td>".$rows['email']."</td>";
                    echo "<td>".$rows['phone']."</td>";
                    echo "<td>".$rows['role']."</td>";
                    echo "<td>".$rows['user_points']."</td>";

                    echo "<td class='action-buttons'>
                        <a href='' class='btn-outline btnview' onclick='openViewModal(".$rows['id'].")'>View</a>
                        <a href='editrewards.php?id=".$rows['id']."' class='btn-outline btnedit'>Edit</a>
                        <a href='deleterewards.php?id=".$rows['id']."' class='btn-outline btndelete'>Delete</a>
                    </td>";

                }

                mysqli_close($dbConn);

                ?>
                </table>
        </main>

        <!-- Start Add Reward Model -->
        <div id="myAddUserModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New User</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Full Name" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-input" name="email" placeholder="Enter Email" />
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-input" name="phone" placeholder="Enter Phone Number" />
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="">
                                    <option value="student">Student</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" >Cancel</button>
                            <button type="submit" class="addbtn" name="addbtn">Add User</button>
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
                $email = $_POST['email'];
                $phone     = $_POST['phone'];
                $role      = $_POST['role'];

                // $sql = "INSERT INTO rewards
                // ( `partners_id`, `name`, `description`, `quantity`, `points_required`, `expired_at`, `status`)
                //         VALUES 
                //         ('$partner','$name', '$description',   '$qty','$points', '$expireddate', '$status')";

                // if (mysqli_query($dbConn, $sql)) {
                //     echo "<script>alert('Reward added successfully!');</script>";
                //     echo "<script>window.location.href='rewards.php';</script>";  
                // } else {
                //     echo "Error: " . mysqli_error($dbConn);
                // }
            }

        ?>

        <div class="modal" id="viewUserModal">
            <div class="modal-box">
                <div class="modal-header">
                    <h3>User Details</h3>
                    <span class="close" onclick="closeModal('viewUserModal')">&times;</span>
                </div>

                <div class="user-header">
                    <div class="avatar">img</div>
                    <div>
                        <h2>Jane Smith</h2>
                        <span class="status active">Active</span>
                    </div>
                </div>

                <div class="stats">
                    <div class="stat-box">
                        <small>Points</small>
                        <strong>100</strong>
                    </div>
                    <div class="stat-box">
                        <small>Items Recycled</small>
                        <strong>20</strong>
                    </div>
                    <div class="stat-box">
                        <small>Member Since</small>
                        <strong>Jan 10, 2025</strong>
                    </div>
                </div>

                <div class="contact">
                    <p><i class="fa-solid fa-envelope"></i> smith@email.com</p>
                    <p><i class="fa-solid fa-phone"></i> 01158697836</p>
                </div>

                <div class="actions">
                    <button class="btn-outline">Add 5 Points</button>
                    <button class="btn-outline">Add 10 Points</button>
                </div>

                <button class="btn-cancel" onclick="closeModal('viewUserModal')">
                    Cancel
                </button>
            </div>
        </div>



    </div>
    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
        var adduserbtn = document.getElementById('addusers');
        var addmodal = document.getElementById('myAddUserModal');
        var spanclose = document.getElementsByClassName('close')[0];


        adduserbtn.onclick = function() {
            addmodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addmodal.style.display = "none";
        }

        


    </script>

</body>
</html>