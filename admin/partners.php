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
                    <h1>Partners</h1>
                    <p>Manage your EcoReward Partners.</p>
                </div>
                

                <button class="adduser" id="addpartners">
                    <i class="fa-solid fa-plus"></i>
                     Add Partners
                </button>
            </div>

            <form action="" method="post" class="searchform">
                <div class="search-container">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Search by name......">
                    </div>

                    <button type="submit" class="btnsearch" name="btnsearch">Search</button>
                </div>
                
            </form>

            <?php
                include 'conn.php';

                

            ?>
            

            <div class="partners">

                <?php 

                    

                    // if(isset($_POST['btnsearch'])){
                    //     $search_key = isset($_POST['search'])? $_POST['search']: '';

                    //     echo "<script>alert('".$search_key."');</script>";

                    //     if($search_key == NULL){
                    //         echo "<script>alert('Please key in your search key first!');</script>";
                    //     }else{
                    //         $sql="SELECT* FROM partners WHERE name LIKE '%".$search_key. "%'"; 
                    //     echo "<script>alert('".$sql."');</script>";

                    //         $result=mysqli_query($dbConn, $sql); 

                    //         if(mysqli_num_rows($result) <= 0) 
                    //         { 
                    //             echo "<script>alert('No Result!');</script>"; 
                    //         } 
                    //         else 
                    //         { 
                    //             $sql = "Select * From partners";
                    //             $result = mysqli_query($dbConn,$sql);

                    //             if(mysqli_num_rows($result) <= 0){
                    //                 die("<script>alert('No data from database!);</script>");
                    //             }

                    //             while($rows = mysqli_fetch_array($result)){
                    //                 echo "<div class='partner-card'>";
                    //                 echo "<img src='".$rows['company_image']."' alt='Company Profile' class='company_image' />";
                    //                 echo "<h3>".$rows['name']."</h3>";
                    //                 // echo "<span class='type'>".$rows['name']."</span>";
                    //                 echo "<p><i class='fa-regular fa-envelope'></i> ".$rows['email']."</p>";
                    //                 echo "<p><i class='fa-solid fa-phone'></i>".$rows['phone']."</td>";
                    //                 echo "<p><i class='fa-solid fa-location-dot'></i>".$rows['address']."</td>";                       
                                    

                    //                 echo "<div class='card-actions'>
                    //                     <a href='editpartners.php?id=".$rows['id']."' class='btnpartners btnedit w-50'>Edit</a>
                    //                     <a href='deletepartners.php?id=".$rows['id']."' class='btnpartners btndelete w-50'>Delete</a>
                    //                 </div>";

                    //                 echo "</div>";

                    //             }
                    //         }

                    //     }

                    // }else{
                    //     $sql = "Select * From partners";
                    //     $result = mysqli_query($dbConn,$sql);

                    //     if(mysqli_num_rows($result) <= 0){
                    //         die("<script>alert('No data from database!);</script>");
                    //     }

                    //     while($rows = mysqli_fetch_array($result)){
                    //         echo "<div class='partner-card'>";
                    //         echo "<img src='".$rows['company_image']."' alt='Company Profile' class='company_image' />";
                    //         echo "<h3>".$rows['name']."</h3>";
                    //         // echo "<span class='type'>".$rows['name']."</span>";
                    //         echo "<p><i class='fa-regular fa-envelope'></i> ".$rows['email']."</p>";
                    //         echo "<p><i class='fa-solid fa-phone'></i>".$rows['phone']."</td>";
                    //         echo "<p><i class='fa-solid fa-location-dot'></i>".$rows['address']."</td>";                       
                            

                    //         echo "<div class='card-actions'>
                    //             <a href='editpartners.php?id=".$rows['id']."' class='btnpartners btnedit w-50'>Edit</a>
                    //             <a href='deletepartners.php?id=".$rows['id']."' class='btnpartners btndelete w-50'>Delete</a>
                    //         </div>";

                    //         echo "</div>";

                    //     }

                    // }

                    //haven't finished


                    $sql = "Select * From partners";
                        $result = mysqli_query($dbConn,$sql);

                        if(mysqli_num_rows($result) <= 0){
                            die("<script>alert('No data from database!);</script>");
                        }

                        while($rows = mysqli_fetch_array($result)){
                            echo "<div class='partner-card'>";
                            echo "<img src='".$rows['company_image']."' alt='Company Profile' class='company_image' />";
                            echo "<h3>".$rows['name']."</h3>";
                            // echo "<span class='type'>".$rows['name']."</span>";
                            echo "<p><i class='fa-regular fa-envelope'></i> ".$rows['email']."</p>";
                            echo "<p><i class='fa-solid fa-phone'></i>".$rows['phone']."</td>";
                            echo "<p><i class='fa-solid fa-location-dot'></i>".$rows['address']."</td>";                       
                            

                            echo "<div class='card-actions'>
                                <a href='editpartners.php?id=".$rows['id']."' class='btnpartners btnedit w-50'>Edit</a>
                                <a href='deletepartners.php?id=".$rows['id']."' class='btnpartners btndelete w-50'>Delete</a>
                            </div>";

                            echo "</div>";

                        }
                    

                    

                    mysqli_close($dbConn);

                ?>

                
            </div>
        </main>

        <!-- Start Add Reward Model -->
        <div id="myAddPartnerModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Parnters</h2>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Partner Company Name</label>
                            <input type="text" class="form-input" name="name" placeholder="Enter Partner Company Name" />
                        </div>

                        <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-input" name="email" placeholder="Enter Email" />
                            </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contactperson">Contact Person</label>
                                <input type="text" class="form-input" name="contactperson" placeholder="Enter Contact Person" />
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-input" name="address" placeholder="Enter Address" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phno">Phone Number</label>
                                <input type="text" class="form-input" name="phno" placeholder="Enter Phone Number" />
                            </div>

                            <div class="form-group">
                                <label for="profile">Company Profile</label>
                                <input type="file" class="form-input" name="profile" placeholder="Browse..." />
                            </div>
                        </div>

                        

                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" name="cancelbtn">Cancel</button>
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
                $email = $_POST['email'];
                $contactperson  = $_POST['contactperson'];
                $phone      = $_POST['phno'];
                $address    = $_POST['address'];

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
                
                echo "<script>$name,$phone,$profileName</script>";

                // $sql = "INSERT INTO partners
                // ( `name`, `company_image`, `email`, `contact_person`,'phone','address')
                //         VALUES 
                //         ('$name','$profilePath', '$email', '$contactperson' , '$phone', '$address')";

                // if (mysqli_query($dbConn, $sql)) {
                //     echo "<script>alert('Partner added successfully!');</script>";
                //     echo "<script>window.location.href='partners.php';</script>";  
                // } else {
                //     echo "Error: " . mysqli_error($dbConn);
                // }
            }

            if(isset($_POST['cancelbtn'])){
                echo "<script>window.location.href='partners.php';</script>";  
            }

            //haven't tested

        ?>


    </div>
    
    <script type="text/javascript">
        var addpartnerbtn = document.getElementById('addpartners');
        var addpartnermodal = document.getElementById('myAddPartnerModal');
        var spanclose = document.getElementsByClassName('close')[0];


        addpartnerbtn.onclick = function() {
            addpartnermodal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        spanclose.onclick = function() {
            addpartnermodal.style.display = "none";
        }
    </script>

    <script src="./assets/js/app.js" type="text/javascript"></script>
</body>
</html>