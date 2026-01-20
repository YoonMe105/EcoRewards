<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>

    <link href="./assets/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

    <style>
        .profile{
    width: 60px;
    height: 60px;
    margin: 0 auto;
}
.profile .adminprofile{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border-radius: 50%;
    object-fit: cover;           
    border: 2px solid #ddd;
}
    </style>
</head>
<body>

    <?php include('topnavbar.php') ?>

    <div class="wrapper">
        <?php include('sidebar.php') ?>

        <main class="main">

            <div class="header">
                <div>
                    <h1>Admins</h1>
                    <p>Manage Adminstrator Accounts.</p>
                </div>
                

                <button class="addusers" id="addadmins">
                    <i class="fa-solid fa-plus"></i>
                     Create Admin
                </button>
            </div>

            <table class="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Profile Picture</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                
                </thead>
                <?php
                include('conn.php');

                $sql = "Select * From admins";
                $result = mysqli_query($dbConn,$sql);

                if(mysqli_num_rows($result) <= 0){
                    die("<script>alert('No data from database!);</script>");
                }

                while($rows = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$rows['id']."</td>";
                    echo "<td>".$rows['fullname']."</td>";
                    echo "<td>
                        <div class='profile'>
                            <img src='".$rows['profile_image']."' alt='Admin Profile' class='adminprofile' />
                        </div>
                    </td>";
                    echo "<td>".$rows['email']."</td>";
                    echo "<td>".$rows['phone']."</td>";
                    echo "<td>".$rows['status']."</td>";

                    echo "<td class='action-buttons'>
                        <a href='editadmins.php?id=".$rows['id']."' class='btn-outline btnedit'>Edit</a>
                        <a href='deleteadmins.php?id=".$rows['id']."' class='btn-outline btndelete'>Delete</a>
                    </td>";

                }

                mysqli_close($dbConn);

                ?>
                </table>
        </main>

        <!-- Start Add Admin Model -->
        <div id="myAddAdminModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Admin</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Admin Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Admin Name" />
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
                                <label for="profile">Profile</label>
                                <input type="file" class="form-input" name="profile" placeholder="Browse..." />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="cancel" class="cancelbtn" name="closebtn">Cancel</button>
                            <button type="submit" class="addbtn" name="addbtn">Add Reward</button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
        <!-- End Add Admin Model -->


        <?php

            include 'conn.php';

            if(isset($_POST['addbtn'])){
                $name        = $_POST['name'];
                $email = $_POST['email'];
                $phone     = $_POST['phone'];

                $profileName = $_FILES['profile']['name'];
                $tmpName     = $_FILES['profile']['tmp_name'];

                if (!empty($profileName)) {
                    $folder = "assets/img/";
                    $newName = basename($profileName);
                    move_uploaded_file($tmpName, $folder . $newName);
                    $profilePath = $folder . $newName;
                } else {
                    $profilePath = "assets/img/default-profile.png";
                }
                

                $sql = "INSERT INTO admins
                ( `fullname`, `profile_image`, `email`, `phone`)
                        VALUES 
                        ('$name','$profilePath', '$email',   '$phone')";

                if (mysqli_query($dbConn, $sql)) {
                    echo "<script>alert('Admin added successfully!');</script>";
                    echo "<script>window.location.href='admins.php';</script>";  
                } else {
                    echo "Error: " . mysqli_error($dbConn);
                }
            }

            if(isset($_POST['cancelbtn'])){
                echo "<script>window.location.href='admins.php';</script>";  
            }

        ?>

    </div>
    
    <script src="./assets/js/app.js" type="text/javascript"></script>
    <script type="text/javascript">
        var addadminbtn = document.getElementById('addadmins');
        var addmodal = document.getElementById('myAddAdminModal');
        var spanclose = document.getElementsByClassName('close')[0];

        addadminbtn.onclick = function() {
            addmodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addmodal.style.display = "none";
        }
    </script>

</body>
</html>