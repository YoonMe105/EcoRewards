<?php
    include 'conn.php';

    $viewUser = null;
    $showUserModal = false;

    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'view') {
        $viewId = (int) $_GET['id'];

        $sql = "SELECT * FROM users WHERE id = $viewId LIMIT 1";
        $result = mysqli_query($dbConn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $viewUser = mysqli_fetch_assoc($result);
            $showUserModal = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <style>
        .userprofile{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border-radius: 50%;
    object-fit: cover;           
    border: 2px solid #ddd;
}
.close-btn{
    border:none;
    font-size: 22px;
    cursor: pointer;
    color: #333;
}
    </style>
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
                

                <button class="adduser" id="addusers">
                    <i class="fa-solid fa-plus"></i>
                     Add users
                </button>
            </div>

            <table class="datatable">
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
                        <a href='?action=view&id=".$rows['id']."' class='btn-outline btnview'>View</a>
                        <a href='edituser.php?id=".$rows['id']."' class='btn-outline btnedit'>Edit</a>
                        <a href='deleteuser.php?id=".$rows['id']."' class='btn-outline btndelete'>Delete</a>
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

            if(isset($_POST['addbtn'])){
                $name    = $_POST['name'];
                $email = $_POST['email'];
                $phone     = $_POST['phone'];
                $role      = $_POST['role'];

                $defaultprofile = './assets/img/user.jpg';

                $sql = "INSERT INTO users
                ( `fullname`, `profile_image`, `email`, `phone`, `role`)
                        VALUES 
                        ('$name','$defaultprofile', '$email',   '$phone','$role')";

                if (mysqli_query($dbConn, $sql)) {
                    echo "<script>alert('User added successfully!');</script>";
                    echo "<script>window.location.href='users.php';</script>";  
                } else {
                    echo "Error: " . mysqli_error($dbConn);
                }
            }
        ?>


        <?php if ($viewUser) { ?>
        <!-- start view details -->
        <div class="modal viewModal" id="viewUserModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>User Details</h3>
                    <button class="close-btn" onclick="closeModal()">✕</button>
                </div>

                <div class="modal-body">
                    <div class="user-header">
                        <div class="avatar">
                            <img src="../User/image/<?= $viewUser['profile_image'] ?>" alt="User" class="userprofile" />
                        </div>
                        <div>
                            <h2><?= $viewUser['fullname']; ?></h2>
                            <span><?= $viewUser['role']; ?></span>
                        </div>
                    </div>

                    <div class="stats">
                        <div class="stat-box">
                            <small>Points</small>
                            <strong><?= $viewUser['user_points']; ?></strong>
                        </div>
                        
                        <div class="stat-box">
                            <small>Member Since</small>
                            <strong><?= date('M d, Y', strtotime($viewUser['created_at'])); ?></strong>
                        </div>
                    </div>

                    <div class="contact">
                        <h4>Contact Information</h4>
                        <p><i class="fa-solid fa-envelope"></i> <?= $viewUser['email']; ?></p>
                        <p><i class="fa-solid fa-phone"></i> <?= $viewUser['phone']; ?></p>
                    </div>

                    <div class="actions">
                        <a href="addpoints.php?id=<?= $viewUser['id']; ?>&points=5" class="btnaddpoint">Add 5 Points</a>
                        <a href="addpoints.php?id=<?= $viewUser['id']; ?>&points=10" class="btnaddpoint">Add 10 Points</a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn cancel" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </div>
        <?php } ?> 
        <!-- haven't finished -->

        



    </div>
    
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

        <?php if ($showUserModal) { ?>
            window.onload = function () {
                document.getElementById('viewUserModal').style.display = 'flex';
            };
            <?php } ?>


        function closeModal() {
            window.location.href = 'users.php';
        }


    </script>
    <script src="./assets/js/app.js" type="text/javascript"></script>


</body>
</html>