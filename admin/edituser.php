<?php

    include "conn.php"; 
    $id=intval($_GET['id']);

    $sql="Select * FROM users WHERE id=$id"; 
    $result=mysqli_query($dbConn, $sql);

    if($rows = mysqli_fetch_array($result)){
        $name = $rows['fullname'];
        $email = $rows['email'];
        $phone = $rows['phone'];
        $role = $rows['role'];
        $points = $rows['user_points'];
    }else{
        echo "<script>alert('No data from db!');</script>"; 
        echo "<script>window.location.href='users.php';</script>"; 

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User</title>
    
    <link href="./assets/css/formupdate.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


    <center>
        <a href="users.php" class="backlink">Back to main page</a>
        <h1>Edit User</h1>

        <form action="" method="post" class="editform">
             <div>
                <label for="uid">ID</label>
                <input type="text" name="uid" value="<?php echo $id;?>" readonly />
            </div>
                        

            <div>
                <label for="name">Full Name</label>
                <input type="text" class="" name="name" value="<?php echo $name;?>"  />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" class="" name="email" value="<?php echo $email;?>"  />
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="text" class="" name="phone" value="<?php echo $phone;?>" />
            </div>

            <div>
                <div>
                    <label for="points">Points</label>
                    <input type="text" class="" name="points" value="<?php echo $points;?>" readonly />
                </div>

                <div>
                    <label for="role">Role</label>
                    <input type="text" class="" name="role" value="<?php echo $role;?>" readonly />
                </div>
            </div>

            

            <button type="submit" class="update" name="submit">Submit</button>

        </form>
    </center>


    <?php

        if(isset($_POST['submit'])){

            $uid = $_POST['uid'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];


            $sql = "UPDATE users SET ".
            "fullname= '$name',".
            "email = '$email',".
            "phone = '$phone' WHERE id = $uid";

            mysqli_query($dbConn,$sql);

            if(mysqli_affected_rows($dbConn)<=0) { 
                die("<script>alert('Cannot update data!');</script>"); 
                
                echo "<script>window.location.href='users.php';</script>";
            } 

            echo "<script>alert('Successfully updated data!');</script>"; 
            echo "<script>window.location.href='users.php';</script>"; 
                }
    ?>


    
</body>
</html>